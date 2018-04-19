<?php

$connString = 'mysql:127.0.0.1;port=3309;dbname=art';
$user = 'ne0s1s';
$password = '';

try
{
    $pdo = new PDO($connString, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    die( $e->getMessage() );
}

function createImage($pdo)
{
    $imageInfo = '';
    if(isset($_GET['paintingID']))
    {
        $pID = $_GET['paintingID'];
        $sql = 'SELECT ImageFileName 
                FROM Paintings  
                WHERE PaintingID = :id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $pID);
        $statement->execute();
        if($row = $statement->fetch())
        {
           $imageInfo = '<div class="nine wide column"><img src="images/art/works/medium/' . $row['ImageFileName'] . '.jpg" alt="..." class="ui big image" id="artwork"><div class="ui fullscreen modal"><div class="image content"><img src="images/art/works/large/' . $row['ImageFileName'] . '.jpg" alt="..." class="image"><div class="description"><p></p></div></div></div></div>'; 
        }
    }
    else
    {
        $imageInfo = '<div class="nine wide column"><img src="images/art/works/medium/114020.jpg" alt="..." class="ui big image" id="artwork"><div class="ui fullscreen modal"><div class="image content"><img src="images/art/works/large/105010.jpg" alt="..." class="image"><div class="description"><p></p></div></div></div></div>';
    }
    $pdo = null;
    return $imageInfo;
}

function createMainInfo($pdo)
{
    $mainInfo = '';
    if (isset($_GET['paintingID']))
    {
        $pID = $_GET['paintingID'];
        $sql = 'SELECT Title, Artists.LastName, Excerpt
                FROM Paintings, Artists
                WHERE Paintings.PaintingID = :id
                AND Paintings.ArtistID = Artists.ArtistID';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $pID);
        $statement->execute();
        if($row = $statement->fetch())
        {
            $mainInfo = '<div class="item"><h2 class="header">' . utf8_encode($row['Title']) . '</h2><h3 >' . utf8_encode($row['LastName']) . '</h3><div class="meta"><p><i class="orange star icon"></i><i class="orange star icon"></i><i class="orange star icon"></i><i class="orange star icon"></i><i class="empty star icon"></i></p><p><em>' . utf8_encode($row['Excerpt']) . '</p></div></div>';
        }
    }
    else
        {
            $mainInfo = '<div class="item"><h2 class="header">Madonna Enthroned</h2><h3 >Giotto</h3><div class="meta"><p><i class="orange star icon"></i><i class="orange star icon"></i><i class="orange star icon"></i><i class="orange star icon"></i><i class="empty star icon"></i></p><p>Madonna Enthroned, also known as the Ognissanti Madonna, is a painting by the Italian late medieval artist Giotto di Bondone, housed in the Uffizi Gallery of Florence, Italy. It is generally dated to around 1310. The painting has a traditional Christian subject, representing the Virgin Mary and the Christ Child seated on her lap, with saints surrounding the two. It is celebrated often as the first painting of the Renaissance due to its newfound naturalism and escape from the constraints of Gothic art.</p></div></div>';
        }
    $pdo = null;
    return $mainInfo;
}

function createMainTabs($pdo)
{
    $mainTabs = '';
    if (isset($_GET['paintingID']))
    {
        $pID = $_GET['paintingID'];
        $sql = 'SELECT Artists.LastName, Artists.ArtistID, YearOfWork, Medium, Width, Height, Galleries.GalleryName, AccessionNumber, CopyrightText, MuseumLink, Genres.GenreName, Genres.GenreID
        FROM Paintings, Artists, Galleries, PaintingGenres, Genres
        WHERE Paintings.PaintingID = :id
        AND Paintings.ArtistID = Artists.ArtistID
        AND Paintings.GalleryID = Galleries.GalleryID
        AND Paintings.PaintingID = PaintingGenres.PaintingID
        AND Genres.GenreID = PaintingGenres.GenreID';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $pID);
        $statement->execute();
        if($row = $statement->fetch())
        {
            $mainTabs = '<div class="ui top attached tabular menu "><a class="active item" data-tab="details"><i class="image icon"></i>Details</a><a class="item" data-tab="museum"><i class="university icon"></i>Museum</a><a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a><a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a></div><div class="ui bottom attached active tab segment" data-tab="details"><table class="ui definition very basic collapsing celled table"><tbody><tr><td>Artist</td><td><a href="single-artist.php?ArtistID=' . $row['ArtistID'] . '">' . utf8_encode($row['LastName']) . '</a></td></tr><tr><td>Year</td><td>' . $row['YearOfWork'] . '</td></tr><tr><td>Medium</td><td>' . $row['Medium'] . '</td></tr><tr><td>Dimensions</td><td>' . $row['Width'] . 'cm x ' . $row['Height'] . 'cm</td></tr></tbody></table></div><div class="ui bottom attached tab segment" data-tab="museum"><table class="ui definition very basic collapsing celled table"><tbody><tr><td>Museum</td><td>' . utf8_encode($row['GalleryName']) . '</td></tr><tr><td>Assession #</td><td>' . $row['AccessionNumber'] . '</td></tr><tr><td>Copyright</td><td>' . $row['CopyrightText'] . '</td></tr><tr><td>URL</td><td><a href="' . $row['MuseumLink'] . '">View painting at museum site</a></td></tr></tbody></table></div><div class="ui bottom attached tab segment" data-tab="genres"><ul class="ui list"><li class="item"><a href="single-genre.php?GenreID=' . $row['GenreID'] . '">' . $row['GenreName'] . '</a></li></ul></div>';
        }
    }
    else
    {
        $mainTabs = '<div class="ui top attached tabular menu "><a class="active item" data-tab="details"><i class="image icon"></i>Details</a><a class="item" data-tab="museum"><i class="university icon"></i>Museum</a><a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a><a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a></div><div class="ui bottom attached active tab segment" data-tab="details"><table class="ui definition very basic collapsing celled table"><tbody><tr><td>Artist</td><td><a href="single-artist.php?ArtistID=114">Giotto</a></td></tr><tr><td>Year</td><td>1310</td></tr><tr><td>Medium</td><td>Tempura on Wood</td></tr><tr><td>Dimensions</td><td>325cm x 204cm</td></tr></tbody></table></div><div class="ui bottom attached tab segment" data-tab="museum"><table class="ui definition very basic collapsing celled table"><tbody><tr><td>Museum</td><td>Uffizi Museum</td></tr><tr><td>Assession #</td><td>1890, 8343</td></tr><tr><td>Copyright</td><td>Public domain</td></tr><tr><td>URL</td><td><a href="http://www.uffizi.firenze.it/catalogo/">View painting at museum site</a></td></tr></tbody></table></div><div class="ui bottom attached tab segment" data-tab="genres"><ul class="ui list"><li class="item"><a href="single-genre.php?GenreID=81">International Gothic</a></li></ul></div>';
    }
    $pdo = null;
    return $mainTabs;
}

function createCost($pdo)
{
    $costTab = '';
    if (isset($_GET['paintingID']))
    {
      $pID = $_GET['paintingID'];
      $sql = 'SELECT Cost FROM paintings WHERE PaintingID = :id';
      $statement = $pdo->prepare($sql);
      $statement->bindValue(':id', $pID);
      $statement->execute();
      if($row = $statement->fetch())
      {
          $costTab = '<div class="ui tiny statistic"><div class="value">$' . number_format($row['Cost']) . '</div></div>';
      }
    }
    else
    {
        $costTab = '<div class="ui tiny statistic"><div class="value">$1,500</div></div>';
    }
    $pdo = null;
    return $costTab;
}

function createDrdn($pdo, $type, $preset, $quantity, $id)
{
    $options = '';
    switch ($type)
    {
        case 'frame':
            $options = '<div class="three wide field"><label>Quantity</label><input type="number" name="quantityOf' . $id . '" value="' . $quantity . '"></div><div class="four wide field"><label>Frame</label><select name="frameOf' . $id . '" class="ui search dropdown" value="' . $preset . '"><option>' . $preset . '</option>';
            $sql = 'SELECT Title FROM TypesFrames';
            break;
        case 'glass':
            $options = '<div class="four wide field"><label>Glass</label><select name="glassOf' . $id . '" class="ui search dropdown" value="' . $preset . '"><option>' . $preset . '</option>';
            $sql = 'SELECT Title FROM TypesGlass';
            break;
        case 'matt':
            $options = '<div class="four wide field"><label>Matt</label><select name="mattOf' . $id . '" class="ui search dropdown" value="' . $preset . '"><option>' . $preset . '</option>';
            $sql = 'SELECT Title FROM TypesMatt';
            break;      
    }
    $statement = $pdo->prepare($sql);
    $statement->execute();
    while($row = $statement->fetch())
    {
        $options .= '<option>' . $row['Title'] . '</option>';
    }
    $options .= '</select></div>';
    $pdo = null;
    return $options;  
}

function createFooter($pdo)
{
    $footer = '';
    if(isset($_GET['paintingID']))
    {
        $pID = $_GET['paintingID'];
        $footer = '<section class="ui doubling stackable grid container"><div class="sixteen wide column"><div class="ui top attached tabular menu "><a class="active item" data-tab="first">Description</a><a class="item" data-tab="second">On the Web</a><a class="item" data-tab="third">Reviews</a></div>';
        $sql = 'SELECT Description, WikiLink, GoogleLink, GoogleDescription FROM paintings WHERE paintingid = :id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $pID);
        $statement->execute();
        if($row = $statement->fetch())
        {
            $footer .= '<div class="ui bottom attached active tab segment" data-tab="first">' . utf8_encode($row['Description']) . '</div><div class="ui bottom attached tab segment" data-tab="second"><table class="ui definition very basic collapsing celled table"><tbody><tr><td>Wikipedia Link</td><td><a href="' . $row['WikiLink'] . '">View painting on Wikipedia</a></td></tr><tr><td>Google Link</td><td><a href="' . $row['GoogleLink'] . '">View painting on Google Art Project</a></td></tr><tr><td>Google Text</td><td>' . $row['GoogleDescription'] . '</td></tr></tbody></table></div>';
        }
    }
    else
    {
        $footer .= '<section class="ui doubling stackable grid container"><div class="sixteen wide column"><div class="ui top attached tabular menu "><a class="active item" data-tab="first">Description</a><a class="item" data-tab="second">On the Web</a><a class="item" data-tab="third">Reviews</a></div><div class="ui bottom attached active tab segment" data-tab="first">
              Madonna Enthroned, also known as the Ognissanti Madonna, is a painting by the Italian late medieval artist Giotto di Bondone, housed in the Uffizi Gallery of Florence, Italy. It is generally dated to around 1310. The painting has a traditional Christian subject, representing the Virgin Mary and the Christ Child seated on her lap, with saints surrounding the two. It is celebrated often as the first painting of the Renaissance due to its newfound naturalism and escape from the constraints of Gothic art.
            </div>	<!-- END DescriptionTab --> <div class="ui bottom attached tab segment" data-tab="second"><table class="ui definition very basic collapsing celled table"><tbody><tr><td>Wikipedia Link</td><td><a href="#">View painting on Wikipedia</a></td></tr><tr><td>Google Link</td><td><a href="#">View painting on Google Art Project</a></td></tr><tr><td>Google Text</td><td></td></tr></tbody></table></div>';
    }
    $pdo = null;
    return $footer;
}

function createReviews($pdo)
{
    $reviews = '';
    $stars = '';
    if(isset($_GET['paintingID']))
    {
        $pID = $_GET['paintingID'];
        $sql = 'SELECT Rating, ReviewDate, Comment FROM reviews, paintings WHERE paintings.PaintingID = :id AND reviews.PaintingID = paintings.PaintingID';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $pID);
        $statement->execute();
        while($row = $statement->fetch())
        {
            for($i = 0; $i < $row['Rating']; $i++)
            {
                $stars .= '<i class="star icon"></i>';
            }
            $reviews .= '<div class="event"><div class="content"><div class="date">' . $row['ReviewDate'] . '</div><div class="meta"><a class="like">' . $stars . '</a></div><div class="summary">' . $row['Comment'] . '</div></div></div><div class="ui divider"></div>';
            $stars = '';
        }
    }
    else
    {
      $reviews .= '<div class="event"><div class="content"><div class="date">12/14/2016</div><div class="meta"><a class="like"><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i></a></div>                    <div class="summary">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ac vestibulum ligula. Nam ac erat sit amet odio semper vulputate. Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse consequat pellentesque tellus, nec molestie tortor mattis eu. Aliquam cursus euismod nisl, vel vulputate metus interdum sit amet. Nam dictum eget ex non posuere. Praesent vel sodales velit. Ut id metus aliquam, egestas leo et, auctor ante.</div></div></div><div class="ui divider"></div><div class="event"><div class="content"><div class="date">8/16/2016</div><div class="meta"><a class="like"><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i></a></div><div class="summary">Donec vel tincidunt quam. Donec sed dictum quam, nec rutrum risus. Praesent ac tortor ut leo luctus cursus nec pharetra odio. Sed id orci id quam commodo congue eget eget erat. Quisque luctus posuere pharetra.</div></div></div>';  
    }
    $pdo = null;
    return $reviews;
}

function createFilterOps($pdo, $type)
{
    $options = '';
    $sql = '';
    
    switch($type)
    {
        case 'artist':
            $options .= '<div class="eight wide field"><label>Artist</label><select name="ArtistID"><option Selected="Selected" Disabled="Disabled">Select Artist</option>';
            $sql = 'SELECT LastName, ArtistID FROM artists';
            break;
        case 'gallery':
            $options .= '<div class="nine wide field"><label>Museum</label><select name="GalleryID"><option Selected="Selected" Disabled="Disabled">Select Gallery</option>';
            $sql = 'SELECT GalleryID, GalleryName FROM Galleries';
            break;
        case 'shape':
            $options .= '<div class="nine wide field"><label>Shape</label><select name="ShapeID"><option Selected="Selected" Disabled="Disabled">Select Shape</option>';
            $sql = 'SELECT ShapeID, ShapeName FROM shapes';
            break;
    }
    
    $statement = $pdo->prepare($sql);
    $statement->execute();
    
    switch($type)
    {
        case 'artist':
            while($row = $statement->fetch())
            {
                $options .= '<option value="' . $row['ArtistID'] . '">' . $row['LastName'] . '</option>';
            }
            break;
        case 'gallery':
            while($row = $statement->fetch())
            {
                $options .= '<option value="' . $row['GalleryID'] . '">' . $row['GalleryName'] . '</option>';
            }
            break;
        case 'shape':
            while($row = $statement->fetch())
            {
                $options .= '<option value="' . $row['ShapeID'] . '">' . $row['ShapeName'] . '</option>';
            }
            break;
    }
    
    $pdo = null;
    $options .= '</select></div>';
    return $options;
}

function createPaintings($pdo)
{
    $paintings = '';
    $aID = '';
    $gID = '';
    $sID = '';
    $sql = ''; 
    $statement = '';
	$cartButton = '';
	$favoritesButton = '';
    
    if (!isset($_GET['ArtistID']) && !isset($_GET['GalleryID']) && !isset($_GET['ShapeID']))
    {
        $sql = 'SELECT ImageFileName, Title, Description, Cost, paintingID, artists.LastName FROM paintings, artists WHERE paintings.ArtistID = artists.ArtistID ORDER BY paintings.YearOfWork Asc LIMIT 20';
        $statement = $pdo->prepare($sql);
        $statement->execute();
    }
    else if (isset($_GET['ArtistID']))
    {
        $aID = $_GET['ArtistID'];
        $sql = 'SELECT ImageFileName, Title, Description, Cost, paintingID, artists.LastName FROM paintings, artists WHERE paintings.ArtistID = :id AND paintings.ArtistID = artists.ArtistID ORDER BY paintings.YearOfWork Asc LIMIT 20';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $aID);
        $statement->execute();
    }
    else if (isset($_GET['GalleryID']))
    {
        $gID = $_GET['GalleryID'];
        $sql = 'SELECT ImageFileName, Title, Description, Cost, paintingID, artists.LastName FROM paintings, artists WHERE paintings.ArtistID = artists.ArtistID AND paintings.GalleryID = :id ORDER BY paintings.YearOfWork Asc LIMIT 20';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $gID);
        $statement->execute(); 
    }
    else
    {
        $sID = $_GET['ShapeID'];
        $sql = 'SELECT ImageFileName, Title, Description, Cost, paintingID, artists.LastName FROM paintings, artists WHERE paintings.ArtistID = artists.ArtistID AND paintings.ShapeID = :id ORDER BY paintings.YearOfWork Asc LIMIT 20';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $sID);
        $statement->execute();  
    }

    while ($row = $statement->fetch())
    {
		    
        $paintings .= '<div class="item"><div class="image"><a href="single-painting.php?paintingID=' . $row['paintingID'] . '"><img class="ui medium image" src="images/art/works/square-medium/' . $row['ImageFileName'] . '.jpg"></a></div><div class="content"><h2 class="header">' . $row['Title'] . '</h2><div class="meta"><span>' . $row['LastName'] . '</span></div><div class="description"><p>' . $row['Description'] . '</p></div><div class="extra"><p>' . $row['Cost'] . '</p>';
		if(isset($_SESSION['cart']) && !empty($_SESSION['cart']))
		{
			if(!ifExistsInSession($row['ImageFileName'], $_SESSION['cart']))
			{
				$paintings .= '<form action="veiwCart.php">';
				$cartButton = '<button class="ui icon orange button type="submit"><i class="unhide icon"></i></button>';
			}
		}
		else
		{
			$paintings .= '<form action="browse-paintings.php"';
			$paintings .= formActionPrinter();
			$paintings .= '" method="post">';
			$cartButton = '<button class="ui icon orange button" type="submit" name="addToCart" value="' . $row['paintingID'] . '"><i class="add to cart icon"></i></button>';
		}
			$paintings .= $cartButton; '</form>';
		if(isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
		{
			if(!ifExistsInSession($row['ImageFileName'], $_SESSION['favorites']))
			{
				$paintings .= '<form action="browse-paintings.php';
				$paintings .= formActionPrinter();
				$paintings .= '" method="post">';
				$favoritesButton = '<button class="ui icon button" type="submit" name="toBeFav" value="' . $row['ImageFileName'] . '"><i class="empty heart icon"></i></button>';
			}
		}
		else
		{
			$paintings .= '<form action="browse-paintings.php';
			$paintings .= formActionPrinter();
			$paintings .= '" method="post">';
			$favoritesButton = '<button class="ui icon button" type="submit" name="toBeFav" value="' . $row['ImageFileName'] . '"><i class="heart icon"></i></button>';
		}
			$paintings .= $favoritesButton . '</div></div></div><div class="ui horizontal divider"></div>';
    }
    

    $pdo = null;
    return $paintings;
}

function formActionPrinter()
{
	$formActionString = '';
	$previousBoolean = false;
	if(isset($_GET['ShapeID']) || isset($_GET['GalleryID']) || isset($_GET['ArtistID']))
				{
					$formActionString .= '?';
					if(isset($_GET['ArtistID']))
					{
						$formActionString .= 'ArtistID=' . $_GET['ArtistID'];
						$previousBoolean = true;
					}
					if(isset($_GET['GalleryID']))
					{
						if($previousBoolean)
						{
							$formActionString .= '&';
						}
						$formActionString .= 'GalleryID=' . $_GET['GalleryID'];
						$previousBoolean = true;
					}
					if(isset($_GET['ShapeID']))
					{
						if($previousBoolean)
						{
							$formActionString .= '&';
						}
						$formActionString .= 'GalleryID=' . $_GET['GalleryID'];
					}
				}
	return $formActionString;
}


function createGenreCards($pdo)
{
    $grid = '';
    $sql = 'SELECT GenreID, GenreName FROM genres ORDER BY EraID ASC, GenreName ASC';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    
    while ($row = $statement->fetch())
    {
        $grid .= '<div class="ui card"><div class="ui image"><img src="images/art/genres/square-medium/' . $row['GenreID'] . '.jpg"></div><div class="content"><div class="description"><a href="single-genre.php?GenreID=' . $row['GenreID'] . '"><h2>' . $row['GenreName'] . '</h2></a></div></div></div>';
    }
    
    $pdo = null;
    return $grid;
}

function createGenreHead($pdo)
{
    $gID = '';
    $sql = '';
    $header = '';
    
    if (isset($_GET['GenreID']))
    {
        $gID = $_GET['GenreID'];
        $sql = 'SELECT GenreID, GenreName, Description FROM genres WHERE GenreID = :id';
    }
    else
    {
        $gID = 87;
        $sql = 'SELECT GenreID, GenreName, Description FROM genres WHERE GenreID = :id';
    }
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $gID);
    $statement->execute();
    
    if ($row = $statement->fetch())
    {
        $header .= '<div class="ui container"><img class="ui medium image" src="images/art/genres/square-medium/' . $row['GenreID'] . '.jpg">
        <div class="ui piled segment"><h1>' . $row['GenreName'] . '</h1><p>' . $row['Description'] . '</p></div></div>';
    }
    
    $pdo = null;
    return $header;
}

function createImageCards($pdo)
{
    $gID = '';
    $sql = '';
    $cards = '';
    
    if (isset($_GET['GenreID']))
    {
        $gID = $_GET['GenreID'];
        $sql = 'SELECT ImageFileName, paintings.PaintingID FROM paintings, paintinggenres where paintings.PaintingID = paintinggenres.PaintingID AND paintinggenres.GenreID = :id';
    }
    else
    {
        $gID = 87;
        $sql = 'SELECT ImageFileName, paintings.PaintingID FROM paintings, paintinggenres where paintings.PaintingID = paintinggenres.PaintingID AND paintinggenres.GenreID = :id';  
    }
    
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $gID);
    $statement->execute();
    
    while ($row = $statement->fetch())
    {
       $cards .= '<div class="ui card"><div class="image"><img src="images/art/works/square-medium/' . $row['ImageFileName'] . '.jpg"></div><div class="content"><a href="single-painting.php?paintingID=' . $row['PaintingID'] . '">View Details</a></div></div>'; 
    }
    
    $pdo = null;
    return $cards;
}

function createArtistHead($pdo)
{
    $aID = '';
    $sql = '';
    $header = '';
    
    if (isset($_GET['ArtistID']))
    {
        $aID = $_GET['ArtistID'];
        $sql = 'SELECT ArtistID, FirstName, LastName, Nationality, YearOfBirth, YearOfDeath, Details FROM artists WHERE ArtistID = :id';
    }
    else
    {
        $aID = 99;
        $sql = 'SELECT ArtistID, FirstName, LastName, Nationality, YearOfBirth, YearOfDeath, Details FROM artists WHERE ArtistID = :id';
    }
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $aID);
    $statement->execute();
    
    if ($row = $statement->fetch())
    {
        $header .= '<div class="ui container"><img class="ui medium image" src="images/art/artists/square-medium/' . $row['ArtistID'] . '.jpg">
        <div class="ui piled segment"><h1>' . $row['FirstName'] . ' ' . $row['LastName'] . '</h1><p>Country of Birth: ' . $row['Nationality'] . '<br>Lifespan: ' . $row['YearOfBirth'] . ' - ' . $row['YearOfDeath'] . '<br><br>' . $row['Details'] . '</p></div></div>';
    }
    
    $pdo = null;
    return $header;  
}

function createPaintingCards($pdo)
{
    $aID = '';
    $sql = '';
    $cards = '';
    
    if (isset($_GET['ArtistID']))
    {
        $aID = $_GET['ArtistID'];
        $sql = 'SELECT ImageFileName, PaintingID FROM paintings WHERE paintings.ArtistID = :id';
    }
    else
    {
        $aID = 99;
        $sql ='SELECT ImageFileName, PaintingID FROM paintings WHERE paintings.ArtistID = :id';  
    }
    
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $aID);
    $statement->execute();
    
    while ($row = $statement->fetch())
    {
       $cards .= '<div class="ui card"><div class="image"><img src="images/art/works/square-medium/' . $row['ImageFileName'] . '.jpg"></div><div class="content"><a href="single-painting.php?paintingID=' . $row['PaintingID'] . '">View Details</a></div></div>'; 
    }
    
    $pdo = null;
    return $cards;
}
?>