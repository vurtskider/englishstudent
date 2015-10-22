<?php
/**
 * Created by PhpStorm.
 * User: Vurt
 * Date: 12.10.2015
 * Time: 22:55
 */
    $base = new mysqli("localhost", "auto", "passwd4auto", "auto");
    $base->set_charset("utf8");
    $action=$_POST['action'];
    if($action=='versions') {
        $data = $base->query("SELECT * FROM `versions` ORDER BY `vid` ASC");
        $res=   '<div id="content">
                <img id="logo" src="img/logouarus.png">
                <img class="content-hr" src="img/content-hr.png">
                <ul id="versions" class="blist">';
        while ($obj = $data->fetch_object()) {
            $res .=   '<li>'.
                        '<div class="version-item blist-item">'.
                        '<div>'.$obj->name.'</div>'.
                        '<ul class="version-local">'.
                        '<li>'.
                        '<p class="v-loc '.(intval($obj->priceua)?:'free').'" data-link="UA_'.$obj->slug.'">UA</p>'.
                        '<p class="v-price '.(intval($obj->priceua)?'dollar':'').'">'.$obj->priceua. '</p>'.
                        '</li>'.
                        '<li>'.
                        '<p class="v-loc '.(intval($obj->priceru)?:'free').'" data-link="RU_'.$obj->slug.'" data-link="RU_'.$obj->slug.'">RU</p>'.
                        '<p class="v-price '.(intval($obj->priceua)?'dollar':'').'">'.$obj->priceru.'</p>'.
                        '</li>'.
                        '</ul>'.
                        '</div>'.
                        '</li>'.
                        '<img class="content-hr" src="img/content-hr.png">';
        }
        $res .= '</ul></div>';
        echo $res;
    }
    $maction=explode('_',$action);
    if(count($maction)==2) {
        $data = $base->query("SELECT * FROM `menuitems` ORDER BY `mid` ASC");
        $res = '<div id="back-bar">
                    <div id="return-back" data-link="versions"><img src="img/arrow-back.png"><p>'.($maction[0]=='UA'?'НАЗАД':'ВОЗВРАТ').'</p></div>
                    <div id="settings"><i class="fa fa-cog"></i></div>
                </div>
                <div id="content">
                <img id="logo" src="img/logo'.mb_strtolower($maction[0]).'.png">
                <img class="content-hr" src="img/content-hr.png">
                <ul id="main" class="blist">';
        while ($obj = $data->fetch_object()) {
            $res .= '<li>
                        <div class="mi blist-item" data-link="'.($obj->slug=='shop'?'versions':$action.'_'.$obj->slug).'">
                            <img src="'.$obj->icon.'" class="mi-icon">
                            <div class="mi-name">'.($maction[0]=='UA'?$obj->nameua:$obj->nameru).'</div>
                        </div>
                    </li>
                    <img class="content-hr" src="img/content-hr.png">';
        }
        $res .= '</ul></div>';
        echo $res;
    }
    if(count($maction)==3) {
        if($maction[2]=='science') {
            $data = $base->query("SELECT * FROM `categories` ORDER BY `cat` ASC");
            $res = '<div id="back-bar">
                        <div id="return-back" data-link="'.$maction[0].'_'.$maction[1].'"><img src="img/arrow-back.png"><p>'.($maction[0]=='UA'?'НАЗАД':'ВОЗВРАТ').'</p></div>
                        <div id="settings"><i class="fa fa-cog"></i></div>
                    </div>
                    <div id="content" class="h90">
                    <div class="pb-scroll">
                    <img id="logo" src="img/logo'.mb_strtolower($maction[0]).'.png">
                    <ul id="categories" class="blist">';
            while ($obj = $data->fetch_object()) {
                if($maction[1]=='Free') {
                    $rows = $base->query("SELECT COUNT(id) cid FROM `freeset` WHERE subject = '$obj->cat'");
                } elseif($maction[1]=='all'){
                    $rows = $base->query("SELECT COUNT(id) cid FROM `all` WHERE subject = '$obj->cat'");
                } else {
                    $rows = $base->query("SELECT COUNT(id) cid FROM `all` WHERE subject = '$obj->cat' AND `level` = '$maction[1]' ");
                }
                $qRows = $rows->fetch_object();
                if($qRows->cid){
                $res .=     '<li>
                                <div class="categorie-item blist-item" data-label="'.$action.'_'.$obj->slug.'_0">
                                    <img src="'.($obj->icon?$obj->icon:'img/cat-glob.png').'" class="cat-icon">
                                    <div class="cat-name">'.$obj->cat.'</div>
                                    <p class="cat-count">('.$qRows->cid.')</p>
                                </div>
                            </li>';
                }
            }
            $res .= '</ul>
                    <ul id="foot-menu" class="hidden">
                        <li id="view" data-link="">Перегляд</li>
                        <li id="science" data-link="">Наука</li>
                    </ul></div>';
            echo $res;
        }
        if($maction[2]=='about') {
            if($maction[0]=='UA') {
                $res = '<div id="back-bar">
                        <div id="return-back" data-link="' . $maction[0] . '_' . $maction[1] . '"><img src="img/arrow-back.png"><p>'.($maction[0]=='UA'?'НАЗАД':'ВОЗВРАТ').'</p></div>
                        <div id="settings"><i class="fa fa-cog"></i></div>
                    </div>
                    <div id="content">
                    <div class="pb-scroll about">
                                            <h2>Про Програму</h2>
                    <ol>
                    <li>Про курс</li>
                    <li>Вигляд фішки</li>
                    <li>Принципи навчання</li>
                    <li>Переглядання</li>
                    <li>Методичні поради</li>
                    </ol>
                    <h3>1. Про курс</h3>
                    <p>Програма "English Student - англійська мова" призначена для осіб, що збираються вивчати англійську мову, головний наголос зроблено на слова і вирази, а також показано як вживаються вони з прийменниками та в реченнях.  Це допомагає швидше імплементувати нові (вивчені) слова у розмовну англійську мову кожного хто її вивчає. Матеріал систематизовано в 30 тематичних категоріях на 4100 фішках + 18 категорій Business English  1000 фішок (назва категорії та рівень складності знаходяться в правому верхньому куті кожної фішки, а номер фішки - в лівому верхньому куті).
                    Аплікація English Student дозволить Вам ефективно і швидко опанувати поданий словниковий запас. За основу вивчення взято метод, розроблений Себастіаном Лайтнером, німецьким спеціалістом в галузі науки і розвитку пам\'яті, Тепер Ви не втрачатимете часу на повторення матеріалу, який був вже вивчений.
                    </p>
                                <h3>2. Вигляд фішки</h3>
                    <img src="img/about/image001.png">
                    Повна крапка позначає головне слово, при цьому:
                    <p>- невизначний артикль (а, an) подано тільки для іменників обчислюваних (countable), а для іменників, які можуть бути обчислювані або ті, які не обчислюються (uncountable), даний артикль подано в дужці.</p>
                    <p>- фонетичну транскрипцію подано тільки для головного слова.
                    Пуста крапка показує можливе використання головного слова.
                    Фонетична транскрипція:</p>
                    <img src="img/about/image002.png">
                    <h3>3. Принципи </h3>
                    <p>Цілий курс представлено на двосторонніх фішках. Перша сторона кожної фішки включає слова українською мовою, а друга - їх переклад на англійську мову. Рекомендовано, першу сторону трактувати як питання і спробувати перевести її на іноземну мову.</p>
                    <img src="img/about/image004.png">
                    <p>Потім необхідно перевірити коректність перекладу, повернувши фішку клавішею "поверни" або використання жесту "перемісти  вниз" (slide down).</p>
                    <img src="img/about/image005.png">
                    <p>Якщо поданий переклад правильний, натисніть стрілку "праворуч" або  застосуйте жест "перемісти праворуч" (slide right). Фішка перейде до наступного рівня.</p>
                    <img src="img/about/image007.png">
                    <p>Якщо Ви не знаєте перекладу, натисніть клавішу стрілки "ліворуч" або застосуйте жест "перемісти ліворуч" (slide left). Фішка повернеться до першої перегородки (незалежно від того, з якої перегородки була одержана).
                    <img src="img/about/image009.png">
                    Проте,  черговість висвітлення фішки і з якої перегородки  вона одержана, вирішує спеціально розроблений алгоритм, що забезпечує оптимальне число повторень. Навчання закінчується, коли всі фішки залишуть останню (зелену) перегородку системи.
                                Дана система гарантує, що  найважчий матеріал повторятиметься так часто - до часу його повного засвоєння, а легший матеріал - настільки рідко, щоб його не забути.</p>

                                <h3>4. Переглядання</h3>
                    <p>Функція "Переглядання" уможливлює перегляд фішок при неактивній системі навчання. Ви можете переглянути всі фішки, окремі категорії, або ті, які Ви вже вивчили.</p>

                                <h3>5. Методичні поради</h3>

                    Дев\'ять принципів ефективного навчання
                    Ви можете збільшити ефективність засвоєння, якщо Ви скористаєтесь порадами Лайтнера:
                    <ol>
                    <li>Принцип «доброї мотивації»<br />
                    Знайдіть ціль, для якої Ви хочете вчитися. Іспит? Подорож? Нова, цікава робота? А може хоббі? Пам\'ятайте про свою мету кожного разу, коли Ви засумніваєтесь у собі (хоч з нашою аплікацією мабуть Вам це не загрожує).</li>
                    <li>Принцип «вільної хвилини»<br />
                    Статистично кожен з нас 1 годину щодня втрачає на доїзд до школи або роботи, стояння в черзі чи в очікуванні на когось. Використовуйте кожну таку хвилину для навчання - це ідеальний момент на включення аплікації і вивчення декількох нових слів.</li>
                    <li>Принцип «15 хвилин щодня»<br />
                    Чверть години щоденної науки набагато більше ефективна ніж 2-годинне навчання раз на тиждень. Найкраще увімкнути собі нагадування (в налаштуваннях програми), щоб не відволікатися від основних справ. Якщо 15 хвилин це для Вас надто довго - розпочніть з 5 хвилин щодня!</li>
                    <li>Принцип «пів секунди»<br />
                    Найшвидше ми засвоюємо інформацію, якщо з нею «зв\'язаний рух». Тому відразу після прочитання українського слова поверніть фішку і погляньте на слово англійською мовою. Повторіть цю дію кілька раз. Потім кількаразово і якнайшвидше повторіть в пам\'яті зв\'язок, що запам\'ятався, напр. "собака - а dog". Це саме зробіть з прикладом. Без обдумувань!</li>
                    <li>Принцип «включення уяви»<br />
                    Завжди старайтесь уявити собі те, що представляє слово чи фраза, яку саме Ви вчите, навіть якщо це абстрактне поняття.</li>
                    <li>Принцип «групування»<br />
                    Важчі слова засвоюйте у групах - чим більше слів у схожому корені (напр. робота, працювати, працівник), тим швидше Ви запам\'ятаєте корінь і зрозумієте систему словотворення. Залишиться тільки підібрати правильне закінчення. Крім того - вчіть цілі речення. Вивчений приклад Вам пригодиться, Ви говоритимете більш плавно, а не підбератимете кожне слово окремо.</li>
                    <li>Принцип «гачків в пам\'яті»<br />
                    Навчання схоже на гірське сходження. Кожне вивчине слово це новий "гачок" в пам\'яті, який дозволяє вбити наступний, - тобто навчитися нового слова. Хто знає 100 слів, легко навчиться 1000, а хто знає 2 мови, легко вивчить 4. Чим більше Ви вивчите , тим легше і швидше засвоюватимете нову інформацію.</li>
                    <li>Принцип «зміни оточення»<br />
                    Коли Ви повторюєте матеріал, робіть це за кожним разом в іншому місці, найкраще також в  іншій порі дня та іншому настрої. Так Ви вивчите слова незалежно від обставин, в яких воно було засвоєне.</li>
                    <li>Принцип «занурення в мову»<br />
                    Цілковите занурення має місце під час перебування за кордоном - в іншомовному середовищі, без контакту з українською мовою. Спробуйте частково створити собі таке середовище через слухання зарубіжних радіостанцій чи перегляду фільмів в оригінальній версії. Так Ви опануєте мелодію мови, типовий акцент, загальні фрази і актуально вживаний словниковий запас.</li>
                    </ol>
                    <p><b>Успіху Вам!</b></p>
                    <br />
                    </div>';
            } 
            else {
                $res = '<div id="back-bar">
                        <div id="return-back" data-link="' . $maction[0] . '_' . $maction[1] . '"><img src="img/arrow-back.png"><p>'.($maction[0]=='UA'?'НАЗАД':'ВОЗВРАТ').'</p></div>
                        <div id="settings"><i class="fa fa-cog"></i></div>
                    </div>
                    <div id="content">
                    <div class="pb-scroll about">
                                            <h2>О Программе</h2>
                    <ol>
                    <li>О курсе</li>
                    <li>Вид фишки</li>
                    <li>Принципы обучения</li>
                    <li>Просматривание</li>
                    <li>Методические советы</li>
                    </ol>
                    <h3>1. О курсе</h3>
                    <p>Программа "English Student - английский язык" предназначена для тех, кто собирается изучать английский язык, главное ударение сделано на слова и выражения, а также показано как употребляются они с предлогами и в предложениях.  Это помогает быстрее имплементировать новые (изученные) слова в разговорный английский язык каждого кто его изучает. Материал систематизирован в 30 тематических категориях на 4100 фишках + 18 категорий Business English на 1000 фишках (название категории и уровень сложности находятся в правом верхнем углу каждой фишки, а номер фишки - в левом верхнем углу).
Аппликация English Student позволит Вам эффективно и быстро овладеть поданным словарным запасом. За базу изучения взято метод, разработанный Себастианом Лайтнером, немецким специалистом в области науки и развития памяти. Теперь Вы не будете терять времени на повторение материала, который был уже изучен.
                    </p>
                                <h3>2. Вид фишки</h3>
                    <img src="img/about/image001.png">
                    Полная точка помечает главное слово, при этом:
                    <p>- неопределимый артикль (а, an) подан только для существительных исчисляемых (countable), а для существительных, которые могут быть исчисляемые или те, которые неичисляются (uncountable), данный артикль подан в скобке.</p>
                    <p>- фонетическая транскрипция подана только для главного слова.
Пустая точка показывает возможное использование главного слова.
                    Фонетическая транскрипция:</p>
                    <img src="img/about/image002.png">
                    <h3>3. Принципы учебы</h3>
                    <p>Целый курс представлен на двусторонних фишках. Первая сторона каждой фишки включает слова украинским языком, а вторая - их перевод на английский язык. Рекомендовано, первую сторону трактовать как вопрос и попробовать перевести ее на иностранный язык.</p>
                    <img src="img/about/image004.png">
                    <p>Потом необходимо проверить корректность перевода, повернув фишку клавишей "поверни" или использование жеста "переместить  вниз" (slide down).</p>
                    <img src="img/about/image005.png">
                    <p>Если поданный перевод правильный, нажмите стрелку "вправо" или  примените жест "переместить вправо" (slide right). Фишка перейдет к следующему уровню.</p>
                    <img src="img/about/image007.png">
                    <p>Если Вы не знаете перевода, нажмите клавишу стрелки "влево" или примените жест "переместить влево" (slide left). Фишка вернется к первой перегородке (независимо от того, из какой перегородки была получена).</p>
                    <img src="img/about/image009.png">
                    <p>Кроме того, очередность освещения фишки из какой перегородки она получена, решает специально разработанный алгоритм, который обеспечивает оптимальное число повторений.  Обучение заканчивается тогда, когда все фишки оставят последнюю (зеленую) перегородку системы.</p>
                    <p>Данная система гарантирует, что  самый тяжелый материал будет повторятся   до времени его полного усвоения, а более легкий материал - настолько редко, чтобы его не забыть.</p>

                                <h3>4. Просмотр</h3>
                    <p>Функция "Просмотр" делает возможным просмотр  фишек при неактивной системе обучения. Вы можете посмотреть все фишки, отдельные категории, или те, какие Вы уже выучили.</p>

                                <h3>5. Методические советы</h3>

                    Девять принципов эффективного обучения
Вы можете увеличить эффективность усвоения, если воспользуетесь советами Лайтнера:

                    <ol>
                    <li>Принцип "доброй мотивации"<br />
                    Найдите цель, для которой Вы хотите учиться. Экзамен? Путешествие? Новая, интересная работа? А может хобби? Помните о своей цели каждый раз, когда Вы усомнитесь в себе (хотя с нашей программой,  по-видимому, Вам это не угрожает).</li>
                    <li>Принцип "свободной минуты"<br />
                    Статистически каждый из нас 1 час ежедневно теряет на путь к школе или работе, стоянию в очереди или в ожидании на кого-то. Используйте каждую такую минуту для учебы - это идеальный момент на включение аппликации и изучение нескольких новых слов.</li>
                                <li>Принцип "15 минут ежедневно"<br />
                    Четверть часа ежедневной науки намного больше эффективна, чем 2-часовая учеба раз в неделю. Лучше всего включить себе напоминание (в настройках программы), чтобы не отвлекаться от основных дел. Если 15 минут это для Вас слишком много - начните с 5 минут ежедневно!</li>
                                <li>Принцип "пол секунды"<br />
                    Быстрее всего мы усваиваем информацию, если с ней "связанное движение". Поэтому сразу после прочтения украинского слова поверните фишку и посмотрите перевод на английский язык. Повторите это действие несколько раз. За етим как можно быстрее повторите в памяти связь, которая запомнилась, напр. "собака - а dog". Это самое сделайте с примером. Без обдумываний!</li>
                                <li>Принцип "Включи воображение"<br />
                    Всегда старайтесь представить себе то, что представляет слово или фраза, которую Вы учите, даже если это абстрактное понятие.</li>
                                <li>Принцип "группирования"<br />
                    Более тяжелые слова усваивайте в группах - чем больше слов в похожем корне (напр. работа, работать, работник), тем быстрее Вы запомните корень и поймете систему словообразования. Останется только подобрать правильное окончание. Кроме того - учите целые предложения. Изученный пример Вам пригодится, Вы будете говорить более плавно, а не пытаться подбирать  каждое слово отдельно.</li>
                    <li>Принцип "крючков в памяти"<br />
                    Учеба похоже на горное восхождение. Каждое изученное  слово это новый "крючок" в памяти, который позволяет убить следующий, - то есть научиться нового слова. Кто знает 100 слов, легко научится 1000, а кто знает 2 языка, легко выучит 4. Чем больше Вы выучите, тем легче и быстрее будете усваивать новую информацию.</li>
                    <li>Принцип "изменения окружения"<br />
                    Когда Вы повторяете материал, делайте это каждый раз в другом месте, лучше всего также в другой половине дня и в другом настроении. Так Вы выучите слова независимо от обстоятельств, в которых они  были  усвоены.</li>
                    <li>Принцип "погружения в язык"<br />
                    Полное погружение имеет место в бытность за рубежом - в иноязычной среде, без контакта с украинским языком. Попробуйте частично создать себе такую среду через слушание зарубежных радиостанций или просмотра фильмов в оригинальной версии. Так Вы овладеете мелодией языка, типичным акцентом, общими фразами и актуально употребляемым словарным запасом.</li>
                    </ol>
                    <p><b>Удачи!</b></p>
                    <br />
                    </div>';
            }
            echo $res;
        }
    }
    if(count($maction)==6) {
        if($maction[5]=='view') {
            $catname = $base->query("SELECT cat FROM `categories` WHERE `slug`='$maction[3]'");
            $catname = $catname->fetch_object();
            $catname = $catname->cat;
            if($maction[1]=='Free') {
                $rows = $base->query("SELECT COUNT(id) cid FROM `freeset` WHERE subject = '$catname'");
            } elseif($maction[1]=='all'){
                $rows = $base->query("SELECT COUNT(id) cid FROM `all` WHERE subject = '$catname'");
            } else {
                $rows = $base->query("SELECT COUNT(id) cid FROM `all` WHERE subject = '$catname' AND `level` = '$maction[1]'");
            }
            $qRows=$rows->fetch_object();
            if($maction[1]=='Free') {
                $rows = $base->query("SELECT * FROM `freeset` WHERE subject = '$catname' LIMIT $maction[4],1");
            } elseif($maction[1]=='all'){
                $rows = $base->query("SELECT * FROM `all` WHERE subject = '$catname' LIMIT $maction[4],1");
            } else {
                $rows = $base->query("SELECT * FROM `all` WHERE subject = '$catname' AND `level` = '$maction[1]' LIMIT $maction[4],1");
            }
            $next=$prev=intval($maction[4]);
            $next++;
            $prev--;
            $item = $rows->fetch_object();
            if($next>=$qRows->cid){
                $next=0;
            }
            if($prev<0){
                $prev=$qRows->cid-1;
            }
            $res = '<div id="back-bar">
                        <div id="return-back" data-link="'.$maction[0].'_'.$maction[1].'_'.$maction[2].'"><img src="img/arrow-back.png"><p>'.($maction[0]=='UA'?'НАЗАД':'ВОЗВРАТ').'</p></div>
                        <div id="settings"><i class="fa fa-cog"></i></div>
                    </div>
                    <div id="letters">
                        <ul id="main-letter">
                            <li id="top-letter">
                                <div id="cat-info">
                                    <p id="cat-counter">'.(intval($maction[4])+1).'['.$qRows->cid.']</p>
                                    <p id="cat-level">'.mb_strtoupper($maction[1]).'</p>
                                </div>
                                <ul class="letter-content">
                                    <li>
                                        <ul>
                                            <li><i class="fa fa-circle"></i>'.$item->word.'</li>
                                            <li class="gray">'.$item->trans.'</li>
                                        </ul>
                                            <i class="fa fa-play-circle-o" data-play="http://auto.pokuponchik.com/'.$item->play.'"></i>
                                    </li>
                                    <li><i class="fa fa-circle-o"></i><span class="gray">'.$item->example.'</span></li>
                                </ul>
                            </li>
                            <li id="bottom-letter">
                                <ul class="letter-content">
                                    <li>
                                        <ul>
                                            <li>'.($maction[0]=='UA'?$item->ukr:$item->rus).'</li>
                                        </ul>
                                    </li>
                                    <li><span class="gray">'.($maction[0]=='UA'?$item->ex_ukr:$item->ex_rus).'</span></li>
                                </ul>
                            </li>
                        </ul>
                        <div id="bg-letter-1" class="bg-letter">
                        </div>
                        <div id="bg-letter-2" class="bg-letter">
                    </div>
                    <ul id="bottom-menu">
                        <li id="bm-prev" data-letter="'.$maction[0].'_'.$maction[1].'_'.$maction[2].'_'.$maction[3].'_'.$prev.'_'.$maction[5].'"></li>
                        <li id="bm-next" data-letter="'.$maction[0].'_'.$maction[1].'_'.$maction[2].'_'.$maction[3].'_'.$next.'_'.$maction[5].'"></li>
                    </ul>
                    </div>';

            echo $res;
        } elseif ($maction[5]=='science'){
            $catname = $base->query("SELECT cat FROM `categories` WHERE `slug`='$maction[3]'");
            $catname = $catname->fetch_object();
            $catname = $catname->cat;
            if($maction[1]=='Free') {
                $rows = $base->query("SELECT COUNT(id) cid FROM `freeset` WHERE subject = '$catname'");
            } elseif($maction[1]=='all'){
                $rows = $base->query("SELECT COUNT(id) cid FROM `all` WHERE subject = '$catname'");
            } else {
                $rows = $base->query("SELECT COUNT(id) cid FROM `all` WHERE subject = '$catname' AND `level` = '$maction[1]'");
            }
            $qRows=$rows->fetch_object();
            if($maction[1]=='Free') {
                $rows = $base->query("SELECT * FROM `freeset` WHERE subject = '$catname' LIMIT $maction[4],1");
            } elseif($maction[1]=='all'){
                $rows = $base->query("SELECT * FROM `all` WHERE subject = '$catname' LIMIT $maction[4],1");
            } else {
                $rows = $base->query("SELECT * FROM `all` WHERE subject = '$catname' AND `level` = '$maction[1]' LIMIT $maction[4],1");
            }
            $next=$prev=intval($maction[4]);
            $next++;
            $prev--;
            $item = $rows->fetch_object();
            if($next>=$qRows->cid){
                $next=0;
            }
            if($prev<0){
                $prev=$qRows->cid-1;
            }
            $res = '<div id="back-bar">
                        <div id="return-back" data-link="'.$maction[0].'_'.$maction[1].'_'.$maction[2].'"><img src="img/arrow-back.png"><p>'.($maction[0]=='UA'?'НАЗАД':'ВОЗВРАТ').'</p></div>
                        <div id="settings"><i class="fa fa-cog"></i></div>
                    </div>
                    <div id="sq-letters">
                        <div id="sq-letter" class="sq-letter">
                            <div id="cat-info">
                                <p id="cat-counter"><i class="fa fa-circle"></i>'.(intval($maction[4])+1).'['.$qRows->cid.']</p>
                                <p id="cat-level">'.mb_strtoupper($maction[1]).'</p>
                            </div>
                            <ul class="letter-content lc1">
                                <li>
                                    <ul>
                                        <li>'.$item->word.'</li>
                                        <li class="gray">'.$item->trans.'</li>
                                    </ul>
                                    <i class="fa fa-play-circle-o" data-play="http://auto.pokuponchik.com/'.$item->play.'"></i>
                                </li>
                                <li><i class="fa fa-circle-o"></i><span class="gray">'.$item->example.'</span></li>
                            </ul>
                            <ul class="letter-content lc2 hidden">
                                <li>
                                    <ul>
                                        <li>'.($maction[0]=='UA'?$item->ukr:$item->rus).'</li>
                                    </ul>
                                </li>
                                <li><i class="fa fa-circle-o"></i><span class="gray">'.($maction[0]=='UA'?$item->ex_ukr:$item->ex_rus).'</span></li>
                            </ul>
                        </div>
                        <div id="sq-bg-letter-1" class="sq-letter">
                        </div>
                        <div id="sq-bg-letter-2" class="sq-letter">
                        </div>
                    </div>
                    <ul id="pg-learn">
                        <li><p>10</p><div class="pg pg-10"></div></li>
                        <li><p>20</p><div class="pg pg-20"></div></li>
                        <li><p>50</p><div class="pg pg-50"></div></li>
                        <li><p>70</p><div class="pg pg-70"></div></li>
                        <li><p>100</p><div class="pg pg-100"></div></li>
                    </ul>
                    <ul id="bottom-menu">
                        <li id="bm-prev" data-letter="'.$maction[0].'_'.$maction[1].'_'.$maction[2].'_'.$maction[3].'_'.$prev.'_'.$maction[5].'"></li>
                        <div id="rotate-card"></div>
                        <li id="bm-next" data-letter="'.$maction[0].'_'.$maction[1].'_'.$maction[2].'_'.$maction[3].'_'.$next.'_'.$maction[5].'"></li>
                    </ul>
                    </div>';

            echo $res;
        }
    }
?>