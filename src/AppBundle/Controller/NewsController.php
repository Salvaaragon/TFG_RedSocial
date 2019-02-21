<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * @Route("/news", name="news")
     */
    public function indexAction(Request $request) {
        setlocale(LC_ALL, 'es_ES');
        date_default_timezone_set('Europe/Madrid');
        $rss_3djuegos = new \DOMDocument();
        $rss_vidaextra = new \DOMDocument();
        $rss_vandal = new \DOMDocument();

        $rss_3djuegos->load('https://www.3djuegos.com/universo/rss/rss.php');
        $rss_vidaextra->load('http://feeds.weblogssl.com/vidaextra');
        $rss_vandal->load('https://vandal.elespanol.com/xml.cgi');

        $feed = array();

        $now_date = new \Datetime('now');
        $now_date = $now_date->format('d-m-Y');

        $spanish_day = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
        $spanish_month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        foreach($rss_3djuegos->getElementsByTagName('item') as $node) {
            
            $date_new = new \Datetime($node->getElementsByTagName('pubDate')->item(0)->nodeValue);
            $date_new_formatted = $date_new->format('d-m-Y');

            $day = $spanish_day[$date_new->format('w')];
            $month = $spanish_month[$date_new->format('n') -1];

            $date_string = $day." ".$date_new->format(' d \d\e ').$month.$date_new->format(' \a \l\a\s H:i');

            if($date_new_formatted == $now_date) {
                $desc = $node->getElementsByTagName('description')->item(0)->nodeValue;
                if($desc[0] == '<') $desc = " ";
                $item = array (
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc' => $desc,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $date_string,
                );
          
                array_push($feed, $item);
            }
        }

        foreach($rss_vidaextra->getElementsByTagName('item') as $node) {
            $date_new = new \Datetime($node->getElementsByTagName('pubDate')->item(0)->nodeValue);
            $date_new_formatted = $date_new->format('d-m-Y');

            $day = $spanish_day[$date_new->format('w')];
            $month = $spanish_month[$date_new->format('n') -1];

            $date_string = $day." ".$date_new->format(' d \d\e ').$month.$date_new->format(' \a \l\a\s H:i');

            if($date_new_formatted == $now_date) {
                $desc = $node->getElementsByTagName('description')->item(0)->nodeValue;
                if($desc[0] == '<') $desc = " ";
                $item = array (
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc' => $desc,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $date_string,
                );
          
                array_push($feed, $item);
            }
        }

        foreach($rss_vandal->getElementsByTagName('item') as $node) {
            $date_new = new \Datetime($node->getElementsByTagName('pubDate')->item(0)->nodeValue);
            $date_new_formatted = $date_new->format('d-m-Y');

            $day = $spanish_day[$date_new->format('w')];
            $month = $spanish_month[$date_new->format('n') -1];

            $date_string = $day." ".$date_new->format(' d \d\e ').$month.$date_new->format(' \a \l\a\s H:i');

            if($date_new_formatted == $now_date) {
                $desc = $node->getElementsByTagName('description')->item(0)->nodeValue;
                if($desc[0] == '<') $desc = " ";
                $item = array (
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc' => $desc,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $date_string,
                );
         
                array_push($feed, $item);
            }
        }

        uasort($feed,array($this,"compare_date"));

        return $this->render('@App/news.html.twig', array(
                'rss' => $feed, 'num_news' => sizeof($feed)
        ));
    }

    private function compare_date($a, $b) {
        if ($a['date'] == $b['date']) {
            return 0;
        }
        return ($a['date'] < $b['date']) ? -1 : 1;
    }
}