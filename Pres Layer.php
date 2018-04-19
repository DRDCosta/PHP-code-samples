<?php

class PresMngr
{
    public $mngr;
    
    function __construct()
    {
        $this->mngr = new DataMngr();
    }
	
	function __get($mngr)
	{
		return $this->$mngr;
	}
    
    public function createSArtist()
    {
        $aID;
        
        if(isset($_GET['ArtistID']) && is_numeric($_GET['ArtistID']))
        {
            $aID = $_GET['ArtistID'];
        }
        else
        {
            $aID = 117;
        }
        $art = $this->mngr->selectArtist($aID);
        return $art;
    }
    
    public function createArtPnt()
    {
        $aID;
        $content = '';
        
        if(isset($_GET['ArtistID']) && is_numeric($_GET['ArtistID']))
        {
            $aID = $_GET['ArtistID'];
        }
        else
        {
            $aID = 117;
        }
        
        $paints = $this->mngr->selectArtPnt($aID);
        
        for($i = 0; $i < count($paints); $i++)
        {
            $pnt = $paints[$i];
            $content .= '<div class="ui card"><div class="image"><img src="images/art/works/square-medium/' . $pnt->imgFlNam . '.jpg"></div><div class="content"><a href="single-painting.php?paintingID=' . $pnt->ID . '">View Details</a></div></div>'; 
        }
        return $content;
    }
    
    public function createBGall()
    {
        $arr = $this->mngr->selectBGall();
        $content = '<tr>';
        
        for($i = 0; $i < count($arr); $i++)
        {
            $gall = $arr[$i];
            $content .= '<td><div class="item"><div class="ui small header"><a href="single-gallery.php?galleryID=' . $gall->ID . '">' . $gall->name . '</a></div>' . $gall->city . ', ' . $gall->country . '</div><td>';
            
            if(($i + 1) % 5 == 0)
            { 
                $content .= '</tr><tr>'; 
            }
        }
        return $content;
    }
    
    public function createBArt()
    {
        $arr = $this->mngr->selectBArt();
        $content = '';
        
        for($i = 0; $i < count($arr); $i++)
        {
            $art = $arr[$i];
            $content .= '<div class="ui card"><div class="ui image"><img src="images/art/artists/square-medium/' . $art->ID . '.jpg"></div><div class="content"><div class="description"><a href="single-artist.php?ArtistID=' . $art->ID . '"><h2>' . $art->fName . ' ' . $art->lName . '</h2></a></div></div></div>';
        }
        return $content;
    }
    
    public function createBSub()
    {
       $arr = $this->mngr->selectBSub();
        $content = '<tr>';
        
        for($i = 0; $i < count($arr); $i++)
        {
            $sub = $arr[$i];
            $content .= '<td><div class="ui small header"><a href="single-subject.php?subjectID=' . $sub->ID . '">' . $sub->name . '</a></div><td>';
            
            if(($i + 1) % 5 == 0)
            { 
                $content .= '</tr><tr>'; 
            }
        }
        return $content; 
    }
    
    public function getSubName()
    {
        $sID;
        
        if(isset($_GET['subjectID']) && is_numeric($_GET['subjectID']))
        {
            $sID = $_GET['subjectID'];
        }
        else
        {
            $sID = 1;
        }
        
        $sub = $this->mngr->selectSubTit($sID);
        $name = $sub->name;
        return $name;
    }
    
    public function getSubPnt()
    {
        $sID;
        $content = '';
        
        if(isset($_GET['subjectID']) && is_numeric($_GET['subjectID']))
        { 
            $sID = $_GET['subjectID']; 
        }
        else
        {
            $sID = 1;
        }
        
        $paintings = $this->mngr->selectSubPnt($sID);
        
        for($i = 0; $i < count($paintings); $i++)
        {
            $pnt = $paintings[$i];
            $content .= '<div class="ui card"><div class="ui image"><img src="images/art/works/square-medium/' . $pnt->imgFlNam . '.jpg"></div><div class="content"><div class="description"><a href="single-painting.php?paintingID=' . $pnt->ID . '">View More</a></div></div></div>';
        }
        return $content;
    }
    
    public function createBGenre()
    {
        $content = '';
        $genres = $this->mngr->selectBGenres();
        
        for($i = 0; $i < count($genres); $i++)
        {
            $gen = $genres[$i];
            $content .= '<div class="ui card"><div class="ui image"><img src="images/art/genres/square-medium/' . $gen->ID . '.jpg"></div><div class="content"><div class="description"><a href="single-genre.php?GenreID=' . $gen->ID . '"><h2>' . $gen->name . '</h2></a></div></div></div>';
        }
        return $content;
    }
    
    public function createSGenre()
    {
        $content = '';
        $gID;
        
        if(isset($_GET['GenreID']))
        { 
            $gID = $_GET['GenreID']; 
        }
        else
        { $gID = 79; }
        
        $genre = $this->mngr->selectSGenre($gID);
        return $genre;
    }
    
    public function createGenPnt()
    {
        $content = '';
        $gID;
        
        if(isset($_GET['GenreID']))
        { 
            $gID = $_GET['GenreID']; 
        }
        else
        { $gID = 79; }
        
        $paintings = $this->mngr->selectGenPnt($gID);
        
        for($i = 0; $i < count($paintings); $i++)
        {
            $pnt = $paintings[$i];
            $content .= '<div class="ui card"><div class="image"><img src="images/art/works/square-medium/' . $pnt->imgFlNam . '.jpg"></div><div class="content"><a href="single-painting.php?paintingID=' . $pnt->ID . '">View Details</a></div></div>';
        }
        return $content;
    }
    
    public function createOptions($type)
    {
        $options;
        $content = '';
        
        switch($type)
        {
            case 'artist':
                $options = $this->mngr->selectArtOps();
                
                for($i = 0; $i < count($options); $i++)
                {
                    $art = $options[$i];
                    $content .= '<option value="' . $art->ID . '">' . $art->lName . '</option>';  
                }
                break;
            case 'gallery':
                $options = $this->mngr->selectGalOps();
                
                for($i = 0; $i < count($options); $i++)
                {
                    $gall = $options[$i];
                    $content .= '<option value="' . $gall->ID . '">' . $gall->name . '</option>';  
                }
                break;
            case 'shape':
                $options = $this->mngr->selectShaOps();
                
                for($i = 0; $i < count($options); $i++)
                {
                    $sha = $options[$i];
                    $content .= '<option value="' . $sha->ID . '">' . $sha->name . '</option>';  
                }
                break;
        }
        return $content;
    }
    
    public function createBPnt()
    {
        $content = '';
        $ID;
        $select;
        $objs;
        
        if(isset($_GET['ArtistID']))
        {
            $ID = $_GET['ArtistID'];
            $select = 1;
        }
        else if(isset($_GET['GalleryID']))
        {
            $ID = $_GET['GalleryID']; 
            $select = 2;
        }
        else if(isset($_GET['ShapeID']))
        {
            $ID = $_GET['ShapeID'];
            $select = 3;
        }
        else if (isset($_GET['pntTitle']))
        {
            $ID = $_GET['pntTitle'];
            $select = 4;
        }
        else
        {
            $ID = null;
            $select = null;
        }
        
        $objs = $this->mngr->selectBPnt($ID, $select);
        $paintings = $objs[0];
        $artists = $objs[1];
        for($i = 0; $i < count($paintings); $i++)
        {
            $pnt = $paintings[$i];
            $art = $artists[$i];
            $content .= '<div class="item"><div class="image"><a href="single-painting.php?paintingID=' . $pnt->ID . '"><img class="ui medium image" src="images/art/works/square-medium/' . $pnt->imgFlNam . '.jpg"></a></div><div class="content"><h2 class="header">' . $pnt->title . '</h2><div class="meta"><span>' . $art->lName . '</span></div><div class="description"><p>' . $pnt->desc . '</p></div><div class="extra"><p>' . $pnt->cost . '</p><button class="ui icon orange button" type="submit" name="addToCart" value="' . $pnt->ID . '"><i class="add to cart icon"></i></button><button class="ui icon button" type="submit" name="addToFavorites" value="' . $pnt->ID . '"><i class="heart icon"></i></button></div></div></div><div class="ui horizontal divider"></div>';
        } 
        return $content;
    }
    
    public function createSPnt()
    {
        $pID;
        $pnt;
        
        if(isset($_GET['paintingID']))
        { $pID = $_GET['paintingID']; }
        else
        { $pID = 214; }
        
        $pnt = $this->mngr->selectSPnt($pID);
        return $pnt;
    }
    
    public function createSPntArt($aID)
    {
        $art = $this->mngr->selectSPntArt($aID);
        return $art;
    }
    
    public function createSPntGal($gID)
    {
        $gal = $this->mngr->selectSPntGal($gID);
        return $gal;
    }
    
    public function createSPntGen($pID)
    {
        $genres = $this->mngr->selectSPntGen($pID);
        $content = '';
        
        for($i = 0; $i < count($genres); $i++)
        {
            $gen = $genres[$i];
            $content .= '<li class="item"><a href="single-genre.php?GenreID=' . $gen->ID . '">' . $gen->name . '</a></li>';
        }
        return $content;
    }
    
    public function createSPntSub($pID)
    {
        $subjects = $this->mngr->selectSPntSub($pID);
        $content = '';
        
        for($i = 0; $i < count($subjects); $i++)
        {
            $sub = $subjects[$i];
            $content .= '<li class="item"><a href="single-subject.php?subjectID=' . $sub->ID . '">' . $sub->name . '</a></li>';
        }
        return $content;
    }
    
    public function createSPntFrm()
    {
        $frames = $this->mngr->selectSPntFrm();
        $content = '';
        
        for($i = 0; $i < count($frames); $i++)
        {
            $frm = $frames[$i];
            $content .= '<option>' . $frm->title . '</option>';
        }
        return $content;
    }
    
    public function createSPntGls()
    {
        $glasses = $this->mngr->selectSPntGls();
        $content = '';
        
        for($i = 0; $i < count($glasses); $i++)
        {
            $gls = $glasses[$i];
            $content .= '<option>' .$gls->title . '</option>';
        }
        return $content;
    }
    
    public function createSPntMat()
    {
        $matts = $this->mngr->selectSPntMat();
        $content = '';
        
        for($i = 0; $i < count($matts); $i++)
        {
            $mat = $matts[$i];
            $content .= '<option>' . $mat->title . '</option>';
        }
        return $content;
    }
    
    public function createSPntRev($pID)
    {
        $reviews = $this->mngr->selectSPntRev($pID);
        return $reviews;
    }
    
    public function createSPntFotRev($reviews)
    {
        $stars = '';
        $content = '';
        
        for($i = 0; $i < count($reviews); $i++)
        {
            $rev = $reviews[$i];
            
            for ($s = 0; $s < $rev->rating; $s++)
            { $stars .= '<i class="star icon"></i>'; }
            
            $content .= '<div class="event"><div class="content"><div class="date">' . $rev->revDt . '</div><div class="meta"><a class="like">' . $stars . '</a></div><div class="summary">' . $rev->comment . '</div></div></div><div class="ui divider"></div>';
            $stars = '';
        }
        return $content;
    }
    
    public function createRevStr($reviews)
    {
        $avg = 0;
        $revAmnt = 0;
        $stars = '';
        
        for($i = 0; $i < count($reviews); $i++)
        {
            $rev = $reviews[$i];
            $avg += $rev->rating;
            $revAmnt++;
        }
        $avg = round($avg / $revAmnt);
        
        for($s = 0; $s < $avg; $s++)
        { $stars .= '<i class="orange star icon"></i>'; }
        
        if($s < 5)
        {
            while($s < 5)
            { 
                $stars .= '<i class="empty star icon"></i>';
                $s++;
            }
        }
        return $stars;
    }
    
    public function createEmpStr()
    {
        $stars = '';
        
        for($i = 0; $i < 5; $i++)
        { $stars .= '<i class="empty star icon"></i>'; }
        return $stars;
    }
    
    public function createSGal()
    {
        $content = '';
        $gID = 0;
        
        if(isset($_GET['galleryID']))
        { $gID = $_GET['galleryID']; }
        else
        { $gID = 20; }
        
        $gal = $this->mngr->selectSGal($gID);
        return $gal;
    }
    
    public function createSGalPnt($gID)
    {
        $content = '';
        $paintings = $this->mngr->selectSGalPnt($gID);
        
        for($i = 0; $i < count($paintings); $i++)
        {
            $pnt = $paintings[$i];
            $content .= '<div class="ui card"><div class="ui image"><img src="images/art/works/square-medium/' . $pnt->imgFlNam . '.jpg"></div><div class="content"><div class="description"><a href="single-painting.php?paintingID=' . $pnt->ID . '">View More</a></div></div></div>';
            
        }
        return $content;
    }
}
?>