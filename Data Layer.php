<?php

class Artist
{
    private $ID;
    private $fName;
    private $lName;
    private $nation;
    private $gender;
    private $YOB;
    private $YOD;
    private $detail;
    private $lnk;
    
    function __construct()
    {}
    
    public function __get($fName)
    { return $this->$fName; }
    
    public function __set($fName, $value)
    { $this->$fName = $value; }
    
    public function getFields()
    {
        return array('ArtistID', 'FirstName', 'LastName', 'Nationality', 'Gender', 'YearOfBirth', 'YearOfDeath', 'Details', 'ArtistLink');
    }
}

class Gallery
{
    private $ID;
    private $name;
    private $natNam;
    private $city;
    private $country;
    private $lat;
    private $long;
    private $webst;
    
    function __construct()
    {}
    
    public function __get($fName)
    { return $this->$fName; }
    
    public function __set($fName, $value)
    { $this->$fName = $value; }
    
    public function getFields()
    { 
        return array('GalleryID', 'GalleryName', 'GalleryNativeName', 'GalleryCity', 'GalleryCountry', 'Latitude', 'Longitude', 'GalleryWebSite'); 
    }
}

class Genre
{
    private $id;
    private $name;
    private $eraID;
    private $desc;
    private $lnk;
    
    function __construct()
    {}
    
    public function __get($name)
    { return $this->$name; }
    
    public function __set($name, $value)
    { $this->$name = $value; }
    
    public function getFields()
    {
        return array('GenreID', 'GenreName', 'EraID', 'Description', 'Link');
    }
}

class Painting
{
    private $ID;
    private $artID;
    private $gallID;
    private $imgFlNam;
    private $title;
    private $shapeID;
    private $museLnk;
    private $accNum;
    private $cpyRgt;
    private $desc;
    private $excer;
    private $YOW;
    private $wdth;
    private $hght;
    private $med;
    private $cost;
    private $MSRP;
    private $gLink;
    private $gDesc;
    private $wLnk;
    
    function __construct()
    {}
    
    public function __get($title)
    { return $this->$title; }
    
    public function __set($title, $value)
    { $this->$title = $value; }
    
    public function getFields()
    {
        return array('PaintingID', 'ArtistID', 'GalleryID', 'ImageFileName', 'Title', 'ShapeID', 'MuseumLink', 'AccessionNumber', 'CopyrightText', 'Description', 'Excerpt', 'yearOfWork', 'Width', 'Height', 'Medium', 'Cost', 'MSRP', 'GoogleLink', 'GoogleDescription', 'WikiLink');
    }
}

class Review
{
    private $id;
    private $pntID;
    private $revDt;
    private $rating;
    private $comment;
    
    function __construct()
    {}
    
    public function __get($id)
    { return $this->$id; }
    
    public function __set($id, $value)
    { $this->$id = $value; }
    
    public function getFields()
    {
        return array('RatingID', 'PaintingID', 'ReviewDate', 'Rating', 'Comment');
    }
}

class Shape
{
    private $ID;
    private $name;
    
    function __construct()
    {}
    
    public function __get($name)
    { return $this->$name; }
    
    public function __set($name, $value)
    { $this->$name = $value; }
    
    public function getFields()
    {
        return array('ShapeID', 'ShapeName');
    }
}

class Subject
{
    private $ID;
    private $name;
    
    function __construct()
    {}
    
    public function __get($name)
    { return $this->$name; }
    
    public function __set($name, $value)
    { $this->$name = $value; }
    
    public function getFields()
    { return array('SubjectID', 'SubjectName'); }
}

class Frame
{
    private $ID;
    private $title;
    private $price;
    private $color;
    private $style;
    
    function __construct()
    {}
    
    public function __get($title)
    { return $this->$title; }
    
    public function __set($title, $value)
    { $this->$title = $value; }
    
    public function getFields()
    { return array('FrameID', 'Title', 'Price', 'Color', 'Syle'); }
}

class Glass
{
    private $ID;
    private $title;
    private $desc;
    private $price;
    
    function __construct()
    {}
    
    public function __get($title)
    { return $this->$title; }
    
    public function __set($title, $value)
    { $this->$title = $value; }
    
    public function getFields()
    { return array('GlassID', 'Title', 'Description', 'Price'); }
}

class Matt
{
    private $ID;
    private $title;
    private $clrCde;
    
    function __construct()
    {}
    
    public function __get($title)
    { return $this->$title; }
    
    public function __set($title, $value)
    { $this->$title = $value; }
    
    public function getFields()
    { return array('MattID', 'Title', 'ColorCode'); }
}

class DataMngr
{
    private $pdo;
    
    function __construct()
    {
        $connString = 'mysql:127.0.0.1;port=3309;dbname=art;charset=UTF8;';
        $user = 'ne0s1s';
        $password = '';
        
        try
        {
            $this->pdo = new PDO($connString, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        { die($e->getMessage()); }
    }
    
    private function getById($fields, $id, $idNam, $tabNam, $order)
    {
        $sql = 'SELECT';
        
        for($i = 0; $i < count($fields); $i++)
        {
            $sql .= ' ' . $fields[$i];
            
            if($i != count($fields) - 1)
            { $sql .= ','; }
        }
        
        $sql .= ' FROM ' . $tabNam .' WHERE ' . $idNam . ' = :id';
        
        if(isset($order))
        {$sql = $this->orderSQL($order, $sql);}
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        return $statement;
    }
    
    private function getByJoin($fields, $id, $idNam, $idNam2, $tabNam, $tabNam2, $order)
    {
        $sql = 'SELECT';
        for($i = 0; $i < count($fields); $i++)
        {
            $sql .= ' ' . $tabNam . '.' . $fields[$i]; 
            
            if($i != count($fields) - 1)
            { $sql .= ','; }
        }
        
        $sql .= ' FROM ' . $tabNam . ', ' . $tabNam2 . ' WHERE ' . $tabNam2 . '.' . $idNam . ' = :id' . ' AND ' . $tabNam . '.' . $idNam2 . ' = ' . $tabNam2 . '.' . $idNam2;
        
        if(isset($order))
        {$sql = $this->orderSQL($order, $sql);}
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        return $statement;
    }
    
    private function getByAll($fields, $tabNam, $order)
    {
        $sql = 'SELECT';
        
        for($i = 0; $i < count($fields); $i++)
        {
            $sql .= ' ' . $fields[$i];
            
            if($i != count($fields) - 1)
            { $sql .= ','; }
        }
        
        $sql .= ' FROM ' . $tabNam;
        if(isset($order))
        {$sql = $this->orderSQL($order, $sql);}
        $statement = $this->pdo->prepare($sql);
        return $statement;
    }
    
    private function orderSQL($order, $sql)
    {
        $sql .= ' ORDER BY ' . $order . ' ASC';
        return $sql;
    }
    
    private function getGenByAll($fields, $tabNam, $order, $order2)
    {
        $sql = 'SELECT';
        
        for($i = 0; $i < count($fields); $i++)
        {
            $sql .= ' ' . $fields[$i];
            
            if($i != count($fields) - 1)
            { $sql .= ','; }
        }
        
        $sql .= ' FROM ' . $tabNam . ' ORDER By ' . $order . ' ASC, ' . $order2 . ' ASC';
        $statement = $this->pdo->prepare($sql);
        return $statement;
    }
    
    private function getPntById($id, $select)
    {
        $sql = 'SELECT ImageFileName, Title, Description, Cost, PaintingID, Artists.LastName FROM Paintings, Artists WHERE Paintings.ArtistID = Artists.ArtistID ';
        $statement = '';
        
        if(isset($id))
        {
            switch($select)
            {
                case 1: $sql .= 'AND Paintings.ArtistID = :id';
                    break;
                case 2: $sql .= 'AND Paintings.GalleryID = :id';
                    break;
                case 3: $sql .= 'AND Paintings.ShapeID = :id';
                    break;
                case 4: $sql .= 'AND Paintings.Title LIKE :id';
                    break;
            }
        }
        $sql .= ' ORDER BY Paintings.YearOfWork ASC LIMIT 20';
        $statement = $this->pdo->prepare($sql);
        
        if (isset($id) && $select != 4)
        { $statement->bindValue(':id', $id); }
        else
        { $statement->bindValue(':id', '%' . $id . '%'); }
        
        return $statement;
    }
     
    public function selectArtist($id)
    {
        $artist = new Artist();
        $fields = $artist->getFields();
        $statement = $this->getById($fields, $id, $fields[0], 'Artists', null);
        $statement->execute();
        
        if($row = $statement->fetch())
        {
            $artist->ID = $row['ArtistID'];
            $artist->fName = $row['FirstName'];
            $artist->lName = $row['LastName'];
            $artist->nation = $row['Nationality'];
            $artist->gender = $row['Gender'];
            $artist->YOB = $row['YearOfBirth'];
            $artist->YOD = $row['YearOfDeath'];
            $artist->detail = $row['Details'];
            $artist->artistlink = $row['ArtistLink'];
        }
        return $artist;
    }
    
    public function selectArtpnt($id)
    {
        $pnt = new Painting();
        $paintings = array();
        $index = 0;
        $arr = $pnt->getFields();
        $fields = array($arr[0], $arr[3]);
        $statement = $this->getById($fields, $id, 'ArtistID', 'Paintings', 'YearOfWork');
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $pnt = new Painting();
            $pnt->ID = $row['PaintingID'];
            $pnt->imgFlNam = $row['ImageFileName'];
            $paintings[$index] = $pnt;
            $index++;
        }
        return $paintings;
    }
    
    public function selectBGall()
    {
        $gal = new Gallery();
        $galleries = array();
        $index = 0;
        $arr = $gal->getFields();
        $fields = array($arr[0], $arr[1], $arr[3], $arr[4]);
        $statement = $this->getByAll($fields, 'Galleries', $fields[1]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $gal = new Gallery();
            $gal->ID = $row['GalleryID'];
            $gal->name = $row['GalleryName'];
            $gal->city = $row['GalleryCity'];
            $gal->country = $row['GalleryCountry'];
            $galleries[$index] = $gal;
            $index++;
        }
        return $galleries;
    }
    
    public function selectBArt()
    {
        $art = new Artist();
        $artists = array();
        $index = 0;
        $arr = $art->getFields();
        $fields = array($arr[0], $arr[1], $arr[2]);
        $statement = $this->getByAll($fields, 'Artists', $fields[1]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $art = new Artist();
            $art->ID = $row['ArtistID'];
            $art->fName = $row['FirstName'];
            $art->lName = $row['LastName'];
            $artists[$index] = $art;
            $index++;
        }
        return $artists;
    }
    
    public function selectBSub()
    {
        $sub = new Subject();
        $subjects = array();
        $index = 0;
        $fields = $sub->getFields();
        $statement = $this->getByAll($fields, 'Subjects', $fields[1]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $sub = new Subject();
            $sub->ID = $row['SubjectID'];
            $sub->name = $row['SubjectName'];
            $subjects[$index] = $sub;
            $index++;
        }
        return $subjects;
    }
    
    public function selectSubTit($id)
    {
        $sub = new Subject();
        $fields = $sub->getFields();
        $statement = $this->getById($fields, $id, $fields[0], 'Subjects', null);
        $statement->execute();
        
        if($row = $statement->fetch())
        {
            $sub->ID = $row['SubjectID'];
            $sub->name = $row['SubjectName'];
        }
        return $sub;
    }
    
    public function selectSubPnt($id)
    {
        $pnt = new Painting();
        $paintings = array();
        $index = 0;
        $arr = $pnt->getFields();
        $fields = array($arr[0], $arr[3]);
        $statement = $this->getByJoin($fields, $id, 'SubjectID', $arr[0], 'Paintings', 'PaintingSubjects', 'YearOfWork');
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $pnt = new Painting();
            $pnt->ID = $row['PaintingID'];
            $pnt->imgFlNam = $row['ImageFileName'];
            $paintings[$index] = $pnt;
            $index++;
        }
        return $paintings;
    }
    
    public function selectBGenres()
    {
        $gen = new Genre();
        $genres = array();
        $index = 0;
        $arr = $gen->getFields();
        $fields = array($arr[0], $arr[1]);
        $statement = $this->getGenByAll($fields, 'Genres', 'EraID', $arr[0]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $gen = new Genre();
            $gen->ID = $row['GenreID'];
            $gen->name = $row['GenreName'];
            $genres[$index] = $gen;
            $index++;
        }
        return $genres;
    }
    
    public function selectSGenre($id)
    {
        $gen = new Genre();
        $arr = $gen->getFields();
        $fields = array($arr[0], $arr[1], $arr[3]);
        $statement = $this->getById($fields, $id, $arr[0], 'Genres', null);
        $statement->execute();
        
        if($row = $statement->fetch())
        {
            $gen = new Genre();
            $gen->ID = $row['GenreID'];
            $gen->name = $row['GenreName'];
            $gen->desc = $row['Description'];
        }
        return $gen;
    }
    
    public function selectGenPnt($id)
    {
        $pnt = new Painting();
        $paintings = array();
        $index = 0;
        $arr = $pnt->getFields();
        $fields = array($arr[0], $arr[3]);
        $statement = $this->getByJoin($fields, $id, 'GenreID', $arr[0], 'Paintings', 'PaintingGenres', 'YearOfWork');
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $pnt = new Painting();
            $pnt->ID = $row['PaintingID'];
            $pnt->imgFlNam = $row['ImageFileName'];
            $paintings[$index] = $pnt;
            $index++;
        }
        return $paintings;
    }
    
    public function selectArtOps()
    {
        $art = new Artist();
        $artists = array();
        $index = 0;
        $arr = $art->getFields();
        $fields = array($arr[0], $arr[2]);
        $statement = $this->getByAll($fields, 'Artists', $arr[2]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $art = new Artist();
            $art->ID = $row['ArtistID'];
            $art->lName = $row['LastName'];
            $artists[$index] = $art;
            $index++;
        }
        return $artists;
    }
    
    public function selectGalOps()
    {
        $gal = new Gallery();
        $galleries = array();
        $index = 0;
        $arr = $gal->getFields();
        $fields = array($arr[0], $arr[1]);
        $statement = $this->getByAll($fields, 'Galleries', $arr[1]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $gal = new Artist();
            $gal->ID = $row['GalleryID'];
            $gal->name = $row['GalleryName'];
            $galleries[$index] = $gal;
            $index++;
        }
        return $galleries;
    }
    
    public function selectShaOps()
    {
        $sha = new Shape();
        $shapes = array();
        $index = 0;
        $arr = $sha->getFields();
        $fields = array($arr[0], $arr[1]);
        $statement = $this->getByAll($fields, 'Shapes', $arr[1]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $sha = new Shape();
            $sha->ID = $row['ShapeID'];
            $sha->name = $row['ShapeName'];
            $shapes[$index] = $sha;
            $index++;
        }
        return $shapes;
    }
    
    public function selectBPnt($id, $select)
    {
        $paintings = array();
        $artists = array();
        $index = 0;
        $statement = $this->getPntById($id, $select);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $art = new Artist();
            $pnt = new Painting();
            $art->lName = $row['LastName'];
            $pnt->imgFlNam = $row['ImageFileName'];
            $pnt->title = $row['Title'];
            $pnt->desc = $row['Description'];
            $pnt->cost = $row['Cost'];
            $pnt->ID = $row['PaintingID'];
            $paintings[$index] = $pnt;
            $artists[$index] = $art;
            $index++;
        }
        $objs = array($paintings, $artists);
        return $objs;
    }
    
    public function selectSPnt($id)
    {
        $pnt = new Painting();
        $fields = $pnt->getFields();
        $statement = $this->getByID($fields, $id, $fields[0], 'Paintings', null);
        $statement->execute();
        
        if($row = $statement->fetch())
        {
            $pnt->ID = $row['PaintingID'];
            $pnt->artID = $row['ArtistID'];
            $pnt->gallID = $row['GalleryID'];
            $pnt->imgFlNam = $row['ImageFileName'];
            $pnt->title = $row['Title'];
            $pnt->shapeID = $row['ShapeID'];
            $pnt->museLnk = $row['MuseumLink'];
            $pnt->accNum = $row['AccessionNumber'];
            $pnt->cpyRgt = $row['CopyrightText'];
            $pnt->desc = $row['Description'];
            $pnt->excer = $row['Excerpt'];
            $pnt->YOW = $row['YearOfWork'];
            $pnt->wdth = $row['Width'];
            $pnt->hght = $row['Height'];
            $pnt->med = $row['Medium'];
            $pnt->cost = $row['Cost'];
            $pnt->MSRP = $row['MSRP'];
            $pnt->gLink = $row['GoogleLink'];
            $pnt->gDesc = $row['GoogleDescription'];
            $pnt->wLnk = $row['WikiLink'];
        }
        return $pnt;
    }
    
    public function selectSPntArt($id)
    {
        $art = new Artist();
        $arr = $art->getFields();
        $fields = array($arr[0], $arr[2]);
        $statement = $this->getByID($fields, $id, $fields[0], 'Artists', null);
        $statement->execute();
        
        if($row = $statement->fetch())
        {
            $art->ID = $row['ArtistID'];
            $art->lName = $row['LastName'];
        }
        return $art;
    }
    
    public function selectSPntGal($id)
    {
        $gal = new Gallery();
        $arr = $gal->getFields();
        $fields = array($arr[0], $arr[1]);
        $statement = $this->getByID($fields, $id, $fields[0], 'Galleries', null);
        $statement->execute();
        
        if($row = $statement->fetch())
        {
            $gal->ID = $row['GalleryID'];
            $gal->name = $row['GalleryName'];
        }
        return $gal;
    }
    
    public function selectSPntGen($id)
    {
        $gen = new Genre();
        $genres = array();
        $index = 0;
        $arr = $gen->getFields();
        $fields = array($arr[0], $arr[1]);
        $statement = $this->getByJoin($fields, $id, 'PaintingID', $fields[0], 'Genres', 'PaintingGenres', null);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $gen = new Genre();
            $gen->ID = $row['GenreID'];
            $gen->name = $row['GenreName'];
            $genres[$index] = $gen;
            $index++;
        }
        return $genres;
    }
    
    public function selectSPntFrm()
    {
        $frm = new Frame();
        $frames = array();
        $index = 0;
        $arr = $frm->getFields();
        $fields = array($arr[1], $arr[2]);
        $statement = $this->getByAll($fields, 'TypesFrames', $fields[0]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $frm = new Frame();
            $frm->title = $row['Title'];
            $frm->price = $row['Price'];
            $frames[$index] = $frm;
            $index++;
        }
        return $frames;
    }
    
    public function selectSPntGls()
    {
        $gls = new Glass();
        $glasses = array();
        $index = 0;
        $arr = $gls->getFields();
        $fields = array($arr[1], $arr[3]);
        $statement = $this->getByAll($fields, 'TypesGlass', $fields[0]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $gls = new Glass();
            $gls->title = $row['Title'];
            $gls->price = $row['Price'];
            $glasses[$index] = $gls;
            $index++;
        }
        return $glasses;
    }
    
    public function selectSPntMat()
    {
        $mat = new Matt();
        $matts = array();
        $index = 0;
        $arr = $mat->getFields();
        $fields = array($arr[1]);
        $statement = $this->getByAll($fields, 'TypesMatt', $fields[0]);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $mat = new Matt();
            $mat->title = $row['Title'];
            $matts[$index] = $mat;
            $index++;
        }
        return $matts;
    }
    
    public function selectSPntRev($id)
    {
        $rev = new Review();
        $reviews = array();
        $index = 0;
        $arr = $rev->getFields();
        $fields = array($arr[2], $arr[3], $arr[4]);
        $statement = $this->getByID($fields, $id, 'PaintingID', 'Reviews', null);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $rev = new Review();
            $rev->revDt = $row['ReviewDate'];
            $rev->rating = $row['Rating'];
            $rev->comment = $row['Comment'];
            $reviews[$index] = $rev;
            $index++;
        }
        return $reviews;
    }
    
    public function selectSPntSub($id)
    {
        $sub = new Subject();
        $subjects = array();
        $index = 0;
        $fields = $sub->getFields();
        $statement = $this->getByJoin($fields, $id, 'PaintingID', $fields[0], 'Subjects', 'PaintingSubjects', null);
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $sub = new Subject();
            $sub->ID = $row['SubjectID'];
            $sub->name = $row['SubjectName'];
            $subjects[$index] = $sub;
            $index++;
        }
        return $subjects;
    }
    
    public function selectSGal($id)
    {
        $gal = new Gallery();
        $fields = $gal->getFields();
        $statement = $this->getById($fields, $id, $fields[0], 'Galleries', null);
        $statement->execute();
        
        if($row = $statement->fetch())
        {
            $gal->ID = $row['GalleryID'];
            $gal->name = $row['GalleryName'];
            $gal->natNam = $row['GalleryNativeName'];
            $gal->city = $row['GalleryCity'];
            $gal->country = $row['GalleryCountry'];
            $gal->lat = $row['Latitude'];
            $gal->long = $row['Longitude'];
            $gal->webst = $row['GalleryWebSite'];
        }
        return $gal;
    }
    
    public function selectSGalPnt($id)
    {
        $pnt = new Painting();
        $paintings = array();
        $index = 0;
        $arr = $pnt->getFields();
        $fields = array($arr[0], $arr[3]);
        $statement = $this->getById($fields, $id, 'GalleryID', 'Paintings', 'YearOfWork');
        $statement->execute();
        
        while($row = $statement->fetch())
        {
            $pnt = new Painting();
            $pnt->ID = $row['PaintingID'];
            $pnt->imgFlNam = $row['ImageFileName'];
            $paintings[$index] = $pnt;
            $index++;
        }
        return $paintings;
    }
}
?>