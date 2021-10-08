<?php
class Application {
        public $error;
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
                $string = 'a:3:{i:0;a:3:{s:10:"week_descr";s:120:"Jeder Anfang ist schwer! 
Regel Nr. 1 lass dir Zeit. Vergiss nicht, dass du deinen ersten Schritt schon gemacht hast.
";s:11:"week_videos";a:1:{i:0;a:2:{s:10:"week_video";s:28:"https://youtu.be/TiXbSZfgyHI";s:16:"week_video_descr";s:169:"Eigenen Körper kennenzulernen und die Schwachstellen erkennen.
Stell dir die Frage : “Wo genau zieht es? Wie atme ich? Wie kann ich mich entspannen?” 
Viel Spaß ";}}s:16:"week_descr_after";s:63:"Описание недели 1 после трансляции";}i:1;a:3:{s:10:"week_descr";s:143:"Weiter so!
Regel Nr. 2  achte auf deine Atmung, erkenne deine Blockaden und Verspannungen. Der Bauch ist einen Zentralpunkt der Entspannung.
";s:11:"week_videos";a:2:{i:0;a:2:{s:10:"week_video";s:41:"https://www.youtube.com/embed/i9GXpIJPqbE";s:16:"week_video_descr";s:37:"Трансляция 1 недели 2";}i:1;a:2:{s:10:"week_video";s:41:"https://www.youtube.com/embed/i9GXpIJPqbE";s:16:"week_video_descr";s:37:"Трансляция 2 недели 2";}}s:16:"week_descr_after";s:63:"Описание недели 2 после трансляции";}i:2;a:3:{s:10:"week_descr";s:139:"Mach weiter!
Regel Nr. 3: Finde „deine“ Position, lerne dich kennen. Schaue wie dein Körper auf eine oder andere Bewegung reagiert.
";s:11:"week_videos";a:1:{i:0;a:2:{s:10:"week_video";s:28:"https://youtu.be/ltesMEFKnQA";s:16:"week_video_descr";s:37:"Трансляция 1 недели 3";}}s:16:"week_descr_after";s:1:" ";}}';     
                $weeks = array();
                $offset = 0;
                $i = 1;
                $offset1 = 0;
                while($this->getWeekDescr($string, $offset)[0] != '') {
                        $weeks[$i] = array();
                        $weeks[$i]['descr'] = $this->getWeekDescr($string, $offset)[0];
                        
                        $offset = $this->getWeekDescr($string, $offset)[1];
                        $offset1 = $offset;

                        $weeks[$i]['descrAfter'] = $this->getWeekDescrAfter($string, $offset)[0];
                        $offset = $this->getWeekDescrAfter($string, $offset)[1];
                        $weeks[$i]['video'] = array();
                        do {
                               $weeks[$i]['video'][] = $this->getWeekVideo($string, $offset1)[0];
                                $offset1 = $this->getWeekVideo($string, $offset1)[1];  
                        }
                        while (($offset > $offset1) && ($this->getWeekVideo($string, $offset1)[0] != ''));

                        $i++;
                }
                foreach ($weeks as $week) {
                        $html .= $week['descr'] . '<br>' . $week['descrAfter'] . '<br>';
                        foreach ($week['video'] as $video) {
                           $html .= $video . '<br>';
                        }

                }
                return $html;
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
                $position = strripos($metaString, 'embed/') + 6;
                return substr($metaString, $position, -4);
        }

        function getWeekDescr($metaString, $offset = 0) {
                $metaString = substr($metaString, $offset);
                $position0 = stripos($metaString, 'week_descr') + 14;
                $trim = substr($metaString, $position0);
                $position1 = stripos($trim, ':') + 2;
                $trim = substr($trim, $position1);
                $position2 = stripos($trim, ';') - 1;
                $trim = substr($trim, 0, $position2);
                return array($trim, $offset + $position0 + $position1 + $position2);
        }

        function getWeekDescrAfter($metaString, $offset = 0) {
                $metaString = substr($metaString, $offset);
                $position0 = stripos($metaString, 'week_descr_after') + 20;
                $trim = substr($metaString, $position0);
                $position1 = stripos($trim, ':') + 2;
                $trim = substr($trim, $position1);
                $position2 = stripos($trim, ';')-1;
                $trim = substr($trim, 0, $position2);
                return array($trim, $offset + $position0 + $position1 + $position2);
        }

        function getWeekVideo($metaString, $offset = 0) {
                $metaString = substr($metaString, $offset);
                $position0 = stripos($metaString, 'week_video"') + 14;
                $trim = substr($metaString, $position0);
                $position1 = stripos($trim, ':') + 2;
                $trim = substr($trim, $position1);
                $position2 = stripos($trim, ';')-1;
                $trim = substr($trim, 0, $position2);
                return array($trim, $offset + $position0 + $position1 + $position2);
        }

        function getWeekVideoDescr($metaString, $offset = 0) {
                $metaString = substr($metaString, $offset);
                $position0 = stripos($metaString, 'week_video_descr') + 20;
                $trim = substr($metaString, $position0);
                $position1 = stripos($trim, ':') + 2;
                $trim = substr($trim, $position1);
                $position2 = stripos($trim, ';')-1;
                $trim = substr($trim, 0, $position2);
                return array($trim, $offset + $position0 + $position1 + $position2);
        }
}
?>