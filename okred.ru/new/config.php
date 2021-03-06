<?php

error_reporting(E_ALL - E_NOTICE);

define('COMPONENT_HOST', 'http://nokred.local/music');
//define('COMPONENT_HOST', '/music');

define('MUSIC_LIMIT_CELLS_MAIN_TRACKS', 100);
define('MUSIC_LIMIT_CELLS_MAIN_ARTISTS', 4);
define('MUSIC_LIMIT_CELLS_SEARCH', 16);

$to_en_layout_map = array(
    'й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']',
    'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '\'',
    'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm', 'б' => ',', 'ю' => '.', '.' => '/',
    'ё' => '`'
);

$genres_on_main = array('Все жанры', 'Rock', 'Pop', 'Rap', /*'House',*/ 'Dance', 'Alternative', /*'Instrumental',*/ 'Metal', 'Dubstep', 'Jazz',
 'Blues', /*'Drum & Bass',*/
 /*'Trance', 'Ethnic',*/ 'Reggae', 'Classical', /*'Electropop', 'Disco', '90s', '80s', '70s', '60s', '50s'*/);

$genres_on_main = array('Все жанры', 'Rock', 'Pop', 'Rap', 'Folk', 'Dance', 'Alternative', 'Relax', 'Metal', 'Jazz',
 'Blues', 'Country', 'Soundtrack', "R'n'b", 'Reggae',
  'Classical', 'Shanson', 'Electronics', '90-s', '80-s', '70-s', '60-s');


$genres_replace_map = array('рок' => 'rock', 'панк' => 'punk', 'рэп' => 'rap', 'реп' => 'rap', 'инди' => 'indie', 'джаз' => 'jazz',
    'хард' => 'hard', 'техно' => 'techno', 'кор' => 'core', 'попса' => 'pop', 'поп' => 'pop', 'народная' => 'folk', 'классика' => 'classic', 'класика' => 'classic',
    'альтернативный' => 'alternative', 'альтернатива' => 'alternative', 'эмбиент' => 'ambient',
    'клубняк' => 'club', 'клубная' => 'club', 'клаб' => 'club', 'диско' => 'disco', 'фьюжн' => 'fusion',
    'бардовская' => 'bardic', 'бард' => 'bard', 'шансон' => 'chanson', 'авторская песня' => 'singer-songwriter',
    /*
     * PAGE: 0, PERPAGE: 250
     */
    '2000' => '00s', // тэгом обозначаются исполнители творчество которых приходится на
    '1960' => '60s', // е годы  десятилетие включающее года с
    '1970' => '70s', // периода с 1970 по 1979 год 
    '1980' => '80s', // ые сюда относится вся музыка выпущенная в
    '1990' => '90s', // для обозначения музыки созданной в 90 х
    'кислота' => 'acid', // произошло в середине 80 х и связано
    'акустика' => 'acoustic', // сыгранная с помощью акустических звучаний инструментов обычно
    'эйдж' => 'age', // эйдж англ new age music музыка новой
    'альбомы' => 'albums', // с англ дословно переводится как quotальбомы которыми
    'альтернативный' => 'alternative', // вместе с гранжем начал набирать популярность в
    'потрясающая' => 'amazing', // музыка при прослушивании которой появляется огромная радость
    'эмбиент' => 'ambient', // от англ dark  тёмный тусклый мрачный
    'америка' => 'american', // американских исполнителей     
    'альт-кантри-фолк' => 'americana',
    'американа' => 'americana', // альт кантри вышли из двух групп во
    'арт' => 'art', // англ art rock  это термин обозначающий
    'атмосферная' => 'atmospheric', // атмосферная музыка от греч atmos дыхание и
    'австрали' => 'australian', // тегом quotaustralianquot подразумевается музыка разных направлений и
    'авангард' => 'avant', // термин используемый для характеристики музыки которая как
    'крутая' => 'awesome', // крутая музычка     
    'баллада' => 'ballad', // представляющая собой медленную мелодичную лирическую композицию баллады
    'барокко' => 'baroque', // барокко называют период в развитии европейской классической
    'прекрасн' => 'beautiful', // не есть объективное субъективное понимание прекрасного обусловлено
    'блэк' => 'black', // англ black metal рус чёрный метал норв
    'блюз' => 'blues', // или ритм энд блюз англ rhythm and
    'босса' => 'bossa', // также босанова порт bossa nova  стиль
    'брейкбит' => 'breakbeat', // англ breakbeat  ломаный ритм  термин
    'брейккор' => 'breakcore', // англ breakcore  стиль экстремальной электронной музыки
    'британская' => 'british', // british объединяет музыку созданную на островах туманного
    'брит' => 'britpop', // поп  жанр альтернативного рока возрождение доминировавшего
    'брутальный' => 'brutal', //  термин использумый для описания дэт метал
    'канадская' => 'canadian', // музыка написанная исполнителями из канады  
    'кельтская' => 'celtic', // музыка  термин используемый для обозначения различных
    'спокойная' => 'chill', // стиль музыки название которого произошло от английского
    'чилаут' => 'chillout',
    'чиллаут' => 'chillout',
    'чил' => 'chillout', // аут от англ chillout chill out music
    'христианский' => 'christian', //  разновидность рок музыки посвящённая теме христианства
    'классический' => 'classic', // весьма расплывчатый термин включающий в себя множество
    'классика' => 'classical', // классикаquot обозначает музыку написанную в классической традиции
    'комедийная' => 'comedy', // включает в себя как  hrefhttpwwwlastfmtagcomedy20rock classbbcode
    'кантри' => 'country', // кантри может относиться к нескольким идеям в
    'кавер' => 'cover', // версия англ cover version  авторская музыкальная
    'дэнс' => 'dance', // dance имеет большое количество форм от disco
    'темная' => 'dark', //  направление в электронно индустриальной музыке непосредственно
    'смерть' => 'death', // музыкальный стиль ответвление от death metal отличающийся
    'дэзкор' => 'deathcore', // англ deathcore  жанр который образовался в
    'дум' => 'doom', // англ doom metal от doom  рок
    'даунтемпо' => 'downtempo', // англ downtempo  заниженный темп или даунбит
    'дрим' => 'dream', // англ dream pop  стиль альтернативного рока
    'drone' => 'drone', // ambient прародителем этого подстиля считается немецкий проект
    'драм' => 'drum', // англ drum and bass  жанр электронной
    'даб' => 'dub', // англ dub  музыкальный жанр возникший в
    'дабстеп' => 'dubstep', // англ dubstep  музыкальный жанр возникший в
    'легкая музыка' => 'easy listening',
    'лёгкая' => 'easy', // англ easy listening  термин в поп
    'электро' => 'electro', //  направление в электронно индустриальной музыке непосредственно
    'электронная' => 'electronic', // музыка от англ electronic music в просторечии
    'электроника' => 'electronica', // включает в себя широкий спектр современной электронной
    'электро' => 'electropop', // поп  подстиль синти попа с преобладанием
    'эмо' => 'emo', // это стиль хардкора 80 х годов изначально
    'эмокор' => 'emocore', // возник в dc district columbia в вашингтоне
    'английская' => 'english', // английских исполнителей или с текстом на английском
    'эпичная' => 'epic', // музыка всё     
    'экcпериментал' => 'experimental', //  музыкальный стиль с экспериментами над звучанием
    'дословный' => 'favourite', // quotлюбимые песниquot     
    'женский' => 'female', // композиции и песни где звучит женский вокал
    'фай' => 'fi',
    'финляндская' => 'finnish', // это тэг которым отмечают исполнителей из финляндии
    'фолк' => 'folk', //  музыкальный жанр сочетающий элементы фольклорной и
    'французская' => 'french', // французского происхождения или артисты исполняющие песни на
    'фанк' => 'funk', // англ funk  одно из основополагающих течений
    'фанки' => 'funky', // funky  направление возникшее в середине конце
    'cовременное' => 'fusion', // стилевое направление возникшее в 1970 е годы
    'гаражный' => 'garage', //  жанр рок музыки сформировавшийся в сша
    'музыкальный' => 'garde', // термин используемый для характеристики музыки которая как
    'немецкая' => 'german', // тег присваивается исполнителям из германии а также
    'глэм' => 'glam', // англ glam rock от glamorous  эффектный
    'готик' => 'gothic', // англ gothic rock  музыкальный жанр являющийся
    'гpайнд' => 'grindcore', // ещё известен как гpайндкоp англ grindcore 
    'гранж' => 'grunge', // англ grunge  стилистическое направление в рок
    'виртуоз' => 'guitar', // исполнитель чаще музыкант мастерски владеющий техникой искусства
    'счастлив' => 'happy', // тег которым пользователи отмечают те композиции или
    'хард' => 'hard', // англ hard rock дословно тяжелый рок или
    'хардкор' => 'hardcore', // hardcore  отяжелевший и более жёсткий панк
    'хеви' => 'heavy', // англ heavy metal дословно тяжёлый металл 
    'хип' => 'hip', // от англ underground  подполье подпольный under
    'хоп' => 'hop', // от англ underground  подполье подпольный under
    'хаус' => 'house', // англ house  жанр электронной музыки созданный
    'айдиэм' => 'idm', // англ intelligent dance music  условное обозначение
    'инди' => 'indie', // инди поп уже существует противоречие так как
    'индастриал' => 'industrial', // is a musical genre that fuses industrial
    'инструментальная' => 'instrumental', // музыка  музыка или запись которая в
    'ирландская' => 'irish', // музыкой обобщенно называют любую музыку которая был
    'иальянская' => 'italian', // с берегов аппенинского полуострова   
    'японская' => 'japanese', // что относится к японской музыке в том
    'джаз' => 'jazz', //  обобщающее понятие появившееся в конце 1990
    'кэй' => 'kei', // яп ヴィジュアル系 видзюару кэй  субкультура возникшая
    'латинская' => 'latin', // всего этот тег используется для обозначения музыки
    'музыка' => 'music',
    'лоу' => 'lo', // lo fi англ quotlow fidelityquot  quotнизкое
    'лаунж' => 'lounge', // англ lounge music  термин в современной
    'любви' => 'love', // любимые песни  песни о любви и
    'мужской' => 'male', // которой присутствует мужской вокал   
    'средневековая' => 'medieval', // medieval заключает в себе европейскую музыку написанную
    'меланхолия' => 'melancholic', // от греч μελας и κολος  чёрная
    'меланхолия' => 'melancholy', // от греч μελας и κολος  чёрная
    'меллоу' => 'mellow', // mellow music обычно подразумевают мягкий и приятный
    'мелоу' => 'mellow', // mellow music обычно подразумевают мягкий и приятный
    'мелодичная' => 'melodic', // не является музыкальным жанром этим термином обычно
    'метал' => 'metal', // также паган  пэган  пейган метал
    'металкор' => 'metalcore', // англ metalcore  жанр хардкора основанный на
    'минимал' => 'minimal', // англ minimal techno  минималистический поджанр техно
    'бразильская' => 'mpb', // popular brazil бразильская популярная музыка  
    'неофолк' => 'neofolk', // дарк фолк апокалиптический фолк англ neofolk dark
    'нью' => 'new', // эйдж англ new age music музыка новой
    'нойз' => 'noise', //  музыка в которой используются звуки считающиеся
    'норвежские' => 'norwegian', // исполнители      
    'нова' => 'nova', // также босанова порт bossa nova  стиль
    'ню' => 'nu', //  обобщающее понятие появившееся в конце 1990
    'старая' => 'oldies', // is a term commonly used to describe
    'паган' => 'pagan', // также паган  пэган  пейган метал
    'языческий' => 'pagan', // также паган  пэган  пейган метал
    'пианино' => 'piano', // музыка в которой акцентом является игра на
    'пиано' => 'piano', // музыка в которой акцентом является игра на
    'польская' => 'polish', // которая пишется в польше или польскими исполнителями
    'полтическая' => 'political', // абсолютно абстрактный стиль в искусстве преобладают политические
    'поп' => 'pop', // англ dream pop  стиль альтернативного рока
    'пост' => 'post', // англ post rock  музыкальный жанр характеризующийся
    'пауэр' => 'power', // англ power metal от power  мощь
    'прогрессивный' => 'progressive', //  подстиль транса название жанра объясняется тем
    'психоделический' => 'psychedelic', // англ psychedelic rock  музыкальный жанр возникший
    'сайкобилли' => 'psychobilly', // англ psychobilly  жанр рок музыки сочетающий
    'психоделический' => 'psytrance', // транс он же пситранс он же псай
    'панк' => 'punk', // панке к традиционным атрибутам панка добавляются типичные
    'рэп' => 'rap', // англ rap rapping  ритмичный речитатив обычно
    'рэпкор' => 'rapcore', //  жанр альтернативной рок музыки характерный использованием
    'регги' => 'reggae', // англ reggae другие варианты написания  регги
    'реггей' => 'reggae', // англ reggae другие варианты написания  регги
    'расслабляющая' => 'relaxing', // и расслабляющая музыка    
    'успокаивающая' => 'relaxing', // и расслабляющая музыка    
    'ремикс' => 'remix', // англ re mix  версия музыкального произведения
    'ритм' => 'rhythm', // или ритм энд блюз англ rhythm and
    'аранби' => 'rnb', // ар энд би англ contemporary rampb который
    'ар энд би' => 'rnb', // ар энд би англ contemporary rampb который
    'рок' => 'rock', //  разновидность рок музыки посвящённая теме христианства
    'рокабилли' => 'rockabilly', // англ rockabilly  разновидность рок н ролла
    'ролл' => 'roll', // англ rocknroll от rock and roll 
    'романтическая' => 'romantic', // музыке направление романтизма сложилось в 1820 е
    'романтик' => 'romantic', // музыке направление романтизма сложилось в 1820 е
    'русский' => 'russian', //  русскоязычная рок музыка создававшаяся в ссср
    'грустная' => 'sad', // тегом отмечена грустная меланхоличная музыка  
    'скримо' => 'screamo', // англ screamo от scream  крик вопль
    'шугэзинг' => 'shoegaze', // или shoegaze англ уставившийся на ботинки от
    'сладж' => 'sludge', // англ sludge  стиль тяжёлой музыки находящийся
    'смус' => 'smooth', // перед словом jazz означает гладкий тихий симпатичный
    'мягкий' => 'soft', // мягкий рок англ так же относящийся к
    'песни' => 'songs', // quotлюбимые песниquot     
    'автор-исполнитель' => 'singersongwriter', // приписывается исполнителям которые сами пишут сочиняют и
    'singersongwriter' => 'songwriter', // приписывается исполнителям которые сами пишут сочиняют и
    'соул' => 'soul', // от английского soul  душа  наиболее
    'саундтрек' => 'soundtrack', //  звуковая дорожка музыкальное оформление какого либо
    'испанская' => 'spanish', // которая пишется в испании или испанскими исполнителями
    'спид' => 'speed', // англ speed metal от speed  скорость
    'стоунер' => 'stoner', //  hrefhttpwwwlastfmtagstoner20rock classbbcode tag reltagstoner rock пустынный
    'шведская' => 'swedish', // которая пишется в швеции или шведскими исполнителями
    'свинг' => 'swing', // свинг в джазе имеет несколько смысловых значений
    'симфоник' => 'symphonic', // симфонический метал или симфо метал англ 
    'синти' => 'synth', // музыки в звучании которой доминирующее положение занимает
    'синтипоп' => 'synthpop', // поп музыки в звучании которой доминирующее положение
    'technical' => 'technical', // музыкальный стиль ответвление от death metal отличающийся
    'техно' => 'techno', // англ minimal techno  минималистический поджанр техно
    'трэш' => 'thrash', // метал англ thrash metal от to thrash
    'транс' => 'trance', // англ vocal trance  поджанр музыки транса
    'трип' => 'trip', // от англ trip hop музыкальный жанр так
    'великобритани' => 'uk', // united kingdom те исполнители из великобритании 
    'андеграунд' => 'underground', // от англ underground  подполье подпольный under
    'americore' => 'usa', //       
    'викинг' => 'viking', // или викингский метал англ viking metal 
    'видзюару' => 'visual', // яп ヴィジュアル系 видзюару кэй  субкультура возникшая
    'вокальный' => 'vocal', // англ vocal trance  поджанр музыки транса
    'вокал' => 'vocalist', // композиции и песни где звучит женский вокал
    'вокал' => 'vocals', // композиции и песни где звучит женский вокал
    'волна' => 'wave', // появившийся по аналогии quotновой волныquot в кино
    'народная' => 'world', // музыка народов мира музыка мира этническая музыка
    'этническая' => 'world', // музыка народов мира музыка мира этническая музыка
);
?>