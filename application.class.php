<?php
class Application {
        public $error;
	private $code;
	function login($login, $pass) {
                require_once 'class-phpass.php';
                $hasher = new PasswordHash(8, TRUE);
                require_once '_dataRowSource.class.php';
                $row = new DataRowSource('select id, user_pass from cr_users where user_login = "' . $login . '"');
                if (!$row->getData()) {
                        return 'Нет такого пользователя!';
                        //return false;
                }
                else if (!$hasher->CheckPassword($pass, $row->getValue('user_pass'))) {
                        return 'Неверный пароль';
                }
        	//return $row->getValue('id');
                //return $this->getCourse();
                $string = 'a:1:{s:11:"kurse_video";a:1:{i:0;s:41:"https://www.youtube.com/embed/i9GXpIJPqbE";}}
 <h1>Общее описание курса после видео</h1>
 a:3:{
        i:0;
        a:3:{
                s:10:"week_descr";
                s:120:"Jeder Anfang ist schwer! Regel Nr. 1 lass dir Zeit. Vergiss nicht, dass du deinen ersten Schritt schon gemacht hast.";
                s:11:"week_videos";
                a:1:{
                        i:0;
                        a:2:{
                                s:10:"week_video";
                                s:28:"https://youtu.be/TiXbSZfgyHI";
                                s:16:"week_video_descr";
                                s:169:"Eigenen Körper kennenzulernen und die Schwachstellen erkennen.Stell dir die Frage : “Wo genau zieht es? Wie atme ich? Wie kann ich mich entspannen?” Viel Spaß ";
                        }
                }
                s:16:"week_descr_after";
                s:63:"Описание недели 1 после трансляции";
        }
        i:1;
        a:3:{
                s:10:"week_descr";s:143:"Weiter so!
 Regel Nr. 2  achte auf deine Atmung, erkenne deine Blockaden und Verspannungen. Der Bauch ist einen Zentralpunkt der Entspannung.
 ";s:11:"week_videos";a:2:{i:0;a:2:{s:10:"week_video";s:41:"https://www.youtube.com/embed/i9GXpIJPqbE";s:16:"week_video_descr";s:37:"Трансляция 1 недели 2";}i:1;a:2:{s:10:"week_video";s:41:"https://www.youtube.com/embed/i9GXpIJPqbE";s:16:"week_video_descr";s:37:"Трансляция 2 недели 2";}}s:16:"week_descr_after";s:63:"Описание недели 2 после трансляции";}
 i:2;a:2:{s:10:"week_descr";s:139:"Mach weiter!
 Regel Nr. 3: Finde „deine“ Position, lerne dich kennen. Schaue wie dein Körper auf eine oder andere Bewegung reagiert.
 ";s:11:"week_videos";a:1:{i:0;a:2:{s:10:"week_video";s:28:"https://youtu.be/ltesMEFKnQA";s:16:"week_video_descr";s:37:"Трансляция 1 недели 3";}}}}';
                $patterns = array();
                $patterns[0] = '/a:/';
                $patterns[1] = '/i:/';
                $patterns[2] = '/s:/';
                $replacements = array();
                $replacements[2] = 'a';
                $replacements[1] = 'i';
                $replacements[0] = 's';
                return preg_replace($patterns, $replacements, $string);
	}

        function getCourse() {
                require_once '_dataSource.class.php';
                $rowData = new DataSource('select meta_key as mkey, meta_value as mval from cr_postmeta where post_id = 1446 and (meta_key = "kurse_desc" or meta_key = "kurse_videos" or meta_key = "kurse_desc_after_video" or meta_key = "week" or meta_key = "kurse_descr_after")');
                $data = $rowData->getData();
                $html = '';
                foreach ($data as $row) {
                        $html = $html . $row['mkey'];
                }
                return $html;
        }

        function getVideoId($metaString) {
                $position = strripos($data, 'embed/') + 6;
                return substr($data, $position, -4);
        }
}
?>