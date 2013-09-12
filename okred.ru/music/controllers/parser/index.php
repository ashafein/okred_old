<?php

        include_once 'api.php';
        $results = array();
        set_time_limit(7200);
        
        $tags = LFMapi('chart.getTopTags', array('limit' => 250));
        echo sizeof($tags['tags']['tag']).' on page<br/><br/>';
        
        for( $i = 0, $l = sizeof($tags['tags']['tag']); $i < $l; $i++ ) {
                
                //echo $tags['tags']['tag'][$i]['name'].'<br/>';
                $tag_info = LFMapi('tag.getInfo', array('tag' => $tags['tags']['tag'][$i]['name']));
                //$tag_info['tag']['wiki']['content']
                
                $words = preg_split("/[\s\-\_\'\`]+/", $tags['tags']['tag'][$i]['name']);
                
                $twords = preg_split("/[\s\-\_\'\`]+/", $tag_info['tag']['wiki']['content'], sizeof($words)+8);
                
                for( $j = 0, $jl = sizeof($words); $j < $jl; $j++ ) {
                        $words[$j] = mb_strtolower(preg_replace("/\W+/ui", '', $words[$j]), "utf-8");
                        $twords[$j] = mb_strtolower(preg_replace("/\W+/ui", '', strip_tags($twords[$j])), "utf-8");
                        if( !empty($twords[$j]) && strlen($twords[$j]) > 1 ) {
                                if( !isset($results[$words[$j]]) ) {
                                        $results[$words[$j]] = array($twords[$j]);
                                        $results[$words[$j]][1] = array($twords[$jl+0], $twords[$jl+1], $twords[$jl+2], $twords[$jl+3], $twords[$jl+4], $twords[$jl+5], $twords[$jl+6]);
                                } else if($results[$words[$j]] != $twords[$j]) {
                                        $p = 0;
                                        while( isset($results[$words[$j].'_'.$p]) && $results[$words[$j].'_'.$p] != $twords[$j] ) {
                                                $p++;
                                        }
                                        $results[$words[$j]] = array($twords[$j]);
                                        if( isset($results[$words[$j]][1]) ) {
                                                $results[$words[$j]][1][] = $twords[$jl+0];
                                                $results[$words[$j]][1][] = $twords[$jl+1];
                                                $results[$words[$j]][1][] = $twords[$jl+2];
                                                $results[$words[$j]][1][] = $twords[$jl+3];
                                                $results[$words[$j]][1][] = $twords[$jl+4];
                                                $results[$words[$j]][1][] = $twords[$jl+5];
                                                $results[$words[$j]][1][] = $twords[$jl+6];
                                        } else {
                                                $results[$words[$j]][1] = array($twords[$jl+0], $twords[$jl+1], $twords[$jl+2], $twords[$jl+3], $twords[$jl+4], $twords[$jl+5], $twords[$jl+6]);
                                        }
                                }
                        }
                        //echo $words[$j] . ' - ' . $twords[$j].'<br/>';
                }
                ksort($results);
                /*
                var_dump($words);
                var_dump($twords);
        */
                //echo '<hr/>';
        }
        echo '<pre style="text-align: left">';
        //echo mb_strtolower("Экcпериментал", "utf-8");
        foreach ($results as $key => $value) {
                echo "'".$value[0]."' =>\t\t'".$key."',\t\t//";
                for( $i = 0, $l = sizeof($value[1]); $i < $l; $i ++ ) {
                        echo ' '.mb_strtolower(preg_replace("/\W+/ui", '', strip_tags($value[1][$i])), "utf-8");
                }
                echo PHP_EOL;
        }