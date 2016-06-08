<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Endroid\Bundle\TwitterBundle\EndroidTwitterBundle;

class TwitterController extends Controller
{
  /**
     * @Route("/twitter/testing")
     */
  public function testingAction() {
    $twitter = $this->get('endroid.twitter');

    //define empty tweets array
    $tweets = array();

    $urlParams = '';

    if(isset($_GET) && !empty($_GET)) {

      // Retrieve tweets
      $twitterFeed = $twitter->query('search/tweets', 'GET', 'json', $_GET);
      $decodedTweets = json_decode($twitterFeed->getContent());
      $tweets = $decodedTweets->statuses;

      //build url params for next and back buttons
      if(count($_GET) == 3) {
        $arrayKeys = array_keys($_GET);
        unset($_GET[$arrayKeys[2]]);
      }
      $urlParams = http_build_query($_GET);
    }

    return $this->render('twitter-search.html.twig', array('tweets' => $tweets, 'url' => $urlParams));
  }
}
