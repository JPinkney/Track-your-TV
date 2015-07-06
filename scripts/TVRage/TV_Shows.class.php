<?php

	/**
	 * TV shows class, basic searching functionality
	 *
	 * @package PHP::TVDB
	 * @author Ryan Doherty <ryan@ryandoherty.com>
	 */

	class TV_Shows extends TVRage {

		/**
		 * Searches for tv shows based on show name
		 *
		 * @var string $showName the show name to search for
		 * @access public
		 * @return array An array of TV_Show objects matching the show name
		 **/
		public static function search($showName) {
			$params = array('action' => 'search_tv_shows', 'show_name' => $showName);
			$data = TVRage::request($params);

			if($data) {
				$xml = simplexml_load_string($data);
				$shows = array();
				foreach($xml->show as $show) {
					$shows[] = new TV_Show($show);
                }

				return $shows;
			}
		}

		/**
		 * Find a tv show by the id from TVRage
		 *
		 * @return TV_Show|false A TV_Show object or false if not found
		 **/
		public static function findById($showId) {
			$params = array('action' => 'show_by_id', 'id' => $showId);
			$data = self::request($params);

			if ($data) {
				$xml = simplexml_load_string($data);
				$show = new TV_Show($xml);
				return $show;
			} else {
				return false;
			}
		}

		/**
		 * Find the newest air date by the id from TVRage
		 *
		 * @return last episode data|false a TV_Show object or false if not found
		 *
		**/
		public function getNewestAirDate($showId){
			$params = array('action' => 'get_newest_air_date', 'id' => $showId);
			$data = self::request($params);

			if ($data) {
				
				$xml   = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
    			$array = json_decode(json_encode($xml), TRUE);
    			$seasons = $array['Episodelist']['Season'];
			    $lastSeason = end($seasons);			
			    $lastEpisode = $lastSeason['episode'];

			   	$x = 0;

			   	#Just in case the last airdate in the xml isn't the next airdate
			   	while (date("Y-m-d") > $lastEpisode[$x]['airdate']) {
			    	$x+=1;  		
			    }

    			return $lastEpisode[$x]['airdate'];
			} else {
				return false;
			}
		}
	}
?>
