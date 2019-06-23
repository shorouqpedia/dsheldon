<?php
require_once '../partials/init.php';




/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}
require_once __DIR__ . '/vendor/autoload.php';

$DEVELOPER_KEY = 'AIzaSyCU2BfMC9HnMvUMXm2pUhjGUBR8UPNzue8';
/**/
$categoriesUrl = "https://www.googleapis.com/youtube/v3/videoCategories?part=snippet&regionCode=US&key=" . $DEVELOPER_KEY;
/*
 * Send Request and receive data
 * */
$ch = curl_init();  // prepare the url

//Set the URL that you want to GET by using the CURLOPT_URL option.
curl_setopt($ch, CURLOPT_URL, $categoriesUrl);

//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//Execute the request.
$data = curl_exec($ch);

//Close the cURL handle.
curl_close($ch);
$dataArray = json_decode($data);


// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.

// if (isset($_GET['q']) && isset($_GET['maxResults'])) {
    /*
     * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
     * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
     * Please ensure that you have enabled the YouTube Data API for your project.
     */
//    $DEVELOPER_KEY = 'AIzaSyB2l9pxHd3duwcmGFUFsRAwL0dL0INwd6Q';
    $DEVELOPER_KEY = 'AIzaSyCU2BfMC9HnMvUMXm2pUhjGUBR8UPNzue8';

    $client = new Google_Client();
    $client->setDeveloperKey($DEVELOPER_KEY);

    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);

  //  try {
        
        $htmlBody='';
        // Call the search.list method to retrieve results matching the specified
        // query term.
        $query = isset($_GET['q']) ? $_GET['q'] : 'hole';
        
        $searchResponse = $youtube->search->listSearch('id,snippet', array(
            'q' => $query,
            'maxResults' => 5 ,
            'type' => 'video',
            'videoCategoryId' => 27 ,   //education
        ));

        $videos=[];
        
        foreach ($searchResponse['items'] as $searchResult) {
            $title = $searchResult['snippet']['title'];
            $img = $searchResult['snippet']['thumbnails']['default']['url'];
            $videoId = $searchResult['id']['videoId'];
            $description = $searchResult['snippet']['description'];
            $videoLink = 'https://www.youtube.com/watch?v=' . $videoId;
            $video = array(
                'title'=>$title,
                'video'=>$videoLink,
                'description'=>$description,
                'img'=>$img,
                'category'=>'Education',
                'id' => $videoId
            );
            array_push($videos,$video);
            
            if (!checkDB('video', 'id', $videoId))
            {
                $query = $con->prepare("INSERT INTO `video` (`id`,`title`) VALUES (?,?)");
                $query->execute(array($videoId, $title));
            }
                
        }

        $searchResponse = $youtube->search->listSearch('id,snippet', array(
            'q' => $query,
            'maxResults' => 5 ,
            'type' => 'video',
            'videoCategoryId' => 28 ,   //education
        ));
        foreach ($searchResponse['items'] as $searchResult) {

            $title = $searchResult['snippet']['title'];
            $img = $searchResult['snippet']['thumbnails']['default']['url'];
            $videoId = $searchResult['id']['videoId'];
            $description = $searchResult['snippet']['description'];
            $videoLink = 'https://www.youtube.com/watch?v=' . $videoId;
            $video = array(
                'title'=>$title,
                'video'=>$videoLink,
                'description'=>$description,
                'img'=>$img,
                'category'=>'Science & Technology',
                'id' => $videoId
            );
            
            array_push($videos,$video);
            if (!checkDB('video', 'id', $videoId))
            {
                $query = $con->prepare("INSERT INTO `video` (`id`,`title`) VALUES (?,?)");
                $query->execute(array($videoId, $title));
            }
        }
//
//    } catch (Google_Service_Exception $e) {
//        $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
//            htmlspecialchars($e->getMessage()));
//    } catch (Google_Exception $e) {
//        $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
//            htmlspecialchars($e->getMessage()));
//    }

?>
<?php require_once "headers.php";

if (isset($_GET['id']))
{?>
    <div class="row">
			<div class="col-sm-7" style="padding-top: 110px; padding-left: 40px;">
				<!-- 16:9 aspect ratio -->
				<div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $_GET['id'];?>?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			<div class="col-sm-5" style="padding-top: 120px; padding-right: 50px;">
				<div class="panel panel-warning">
					<div class="panel-footer">
						<b><h4><?php echo $_GET['title'];?></h4></b>
						<div >
							<div class="rating">
					            <span class="rating-star" data-value="5"></span>
					            <span class="rating-star" data-value="4"></span>
					            <span class="rating-star" data-value="3"></span>
					            <span class="rating-star" data-value="2"></span>
					            <span class="rating-star" data-value="1"></span>
					        </div>
					        
					        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
					        <script>
					        $('.rating-star').click(function() {
					            $(this).parents('.rating').find('.rating-star').removeClass('checked');
					            $(this).addClass('checked');
					                
					            var submitStars = $(this).attr('data-value');
					        });
					        </script>
						</div>
					</div>
					<div class="panel-body" style="/*background-color: rgba(252, 253, 149, 0.3)*/"><?php echo $_GET['description'];?></div>
				</div>

			</div>
		</div>
		
		
<?php }
        $x=100;

        foreach($videos as $video) 
        {
                //blocking blocked video
                $query = $con->prepare("SELECT * FROM video WHERE id = ?");
                $query->execute(array($video['id']));
                if ($query->rowCount() > 0)
                {
                    $data = $query->fetchAll(PDO::FETCH_ASSOC)[0];
                    if ($data['blocked']==1) 
                        continue;
                }?>
        <div class="row" style="padding-left:200px;margin-bottom:50px; margin-top:<?php echo $x?>;">

            <div>
				<div class="col-sm-4 col-md-2" style="top:20">
				    <div class="thumbnail">
				    	<img style="height:80;width:100%;" src="<?php echo $video['img'];?>" alt="...">
				    </div>
				</div>
				<div class="col-sm-4 col-md-8">
					<div class="caption">
					    <h3><?php echo $video['title'];?></h3>
					    <p><?php echo $video['description'];?></p>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
                            <input type="hidden" name="title" value="<?php echo $video['title'];?>">
                            <input type="hidden" name="description" value="<?php echo $video['description'];?>">
                            <input type="hidden" name="id" value="<?php echo $video['id'];?>">
                            <input type="submit" value="Watch" class="btn btn-primary">
                        </form>
					</div>
				</div>
            </div>
		</div>
        <?php $x=0; } ?>
<?php require_once "../partials/footer.php";



?>