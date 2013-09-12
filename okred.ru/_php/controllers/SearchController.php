<?php
class SearchController extends BaseController
{
    public function actionIndex()
    {
        if(isset($_GET['type']) && $_GET['type'] == 'ajax')
        {
            $response = array(
                'error'=>false,
                'content'=>'',
                'yandexResults'=>'',
                'googleResults'=>'',
            );
            
            $query = isset($_GET['query']) ? $_GET['query'] : null;
            $page = isset($_GET['page']) ? (int)$_GET['page'] - 1 : 0;
            
            $what = isset($_GET['what']) ? $_GET['what'] : null;
            
            try
            {
                if($what == 'yandex_results' || $what == 'all')
                {
                    try
                    {
                        $yr = new YandexRequest($query, $page);
                        
                        if(!$yr->validate())
                            throw new YException("Ошибка запроса", implode(', ', $yr->errors));
                        
                        $xml = $yr->request();
                        
                        if(!$xml)
                            throw new YException("Ошибка запроса", implode(', ', $yr->errors));
                        
                        if(isset($xml->response->error))
                            throw new YException("Ошибка интерфейса", (string)$xml->response->error);
                        
                        $content = '';
                        
                        $content .= $this->renderPartial('_y_searh_results', array(
                            'results'=>$xml->response->results->grouping->group,
                        ), false);
                        
                        $content .= $this->renderPartial('_y_stat', array(
                            'requestString'=>$xml->request->query,
                            'requestFound'=>(string)$xml->response->results->grouping->{'found-docs-human'},
                        ), false);
                        
                        $pageDocs = $xml->request->groupings->groupby->attributes();
                        
                        $content .= $this->renderPartial('_y_pager', array(
                            'page'=>$page + 1,
                            'pageDocs'=>$pageDocs['groups-on-page'],
                            'resultsCount'=>(int)$xml->response->found,
                        ), false);
                        
                        $response['yandexResults'] = $content;
                    }
                    catch(YException $e)
                    {
                        $response['yandexResults'] = $this->renderPartial('_error', array(
                            'errorCode'=>$e->code(),
                            'errorMessage'=>$e->message(),
                        ), false);
                    }
                }
                
                if($what == 'google_results' || $what == 'all')
                {
                    try
                    {
                        $gr = new GoogleRequest($query, $page);
                        
                        if(!$gr->validate())
                            throw new GException("Ошибка запроса", implode(', ', $gr->errors));
                        
                        $data = $gr->request();
                        
                        if(get_class($data) != 'stdClass')
                            throw new GException("Ошибка запроса", implode(', ', $gr->errors));
                        
                        if((int)$data->responseStatus != 200)
                            throw new GException($data->responseStatus, $data->responseDetails);
                        
                        $content = '';
                        
                        $content .= $this->renderPartial('_g_searh_results', array(
                            'data'=>$data->responseData->results,
                        ), false);
                        
                        $content .= $this->renderPartial('_g_stat', array(
                            'requestFound'=>'Найдено: '. $data->responseData->cursor->resultCount .' документов',
                        ), false);
                        
                        $content .= $this->renderPartial('_g_pager', array(
                            'page'=>$page + 1,
                            'pageDocs'=>GoogleRequest::RSZ,
                            'resultsCount'=>$data->responseData->cursor->estimatedResultCount,
                            'totalPages'=>count($data->responseData->cursor->pages),
                        ), false);
                        
                        $response['googleResults'] = $content;
                    }
                    catch(GException $e)
                    {
                        $response['googleResults'] = $this->renderPartial('_error', array(
                            'errorCode'=>$e->code(),
                            'errorMessage'=>$e->message(),
                        ), false);
                    }
                }
            }
            catch(CException $e)
            {
                
            }
            
            echo json_encode($response);
            
            Gy::app()->end();
        }
        
        /*$gr = new GoogleRequest('php', 6);
        var_dump($gr->request());exit;*/
        //var_dump(json_decode(file_get_contents('http://ajax.googleapis.com/ajax/services/search/web?v=1.0&key=AIzaSyBRwETzaVS-EsPYjFbidXdJjmXJmLm1b2M&q=php&rsz=8&hl=ru')));exit;
        
        $this->render('form_search');
    }
}