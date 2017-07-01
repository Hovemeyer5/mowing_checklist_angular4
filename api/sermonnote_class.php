<?/*

	Author: Rebecca Hovemeyer

	Date: 7/20/13

*/



// database class

require_once('database_class.php');



class sermonnote extends database

{

        //Display Sermon Note for reading

        public function displaySermonNote($id = null, $type)

        {

            $content = "";

            //get the sermon note

            if($id == null)

            {



				$sermonNote = $this->select('sermonnotes', '*', 'sn_temp = 0 and note_type = '. $type, 'sn_date DESC', 1);

            }

            else

            {

                $sermonNote = $this->select('sermonnotes', '*', "sn_id = $id");

                if(empty($sermonNote[0][0])){

                    $content .=  "oh no";

                  //  $sermonNote = $this->select('sermonnotes', '*', null, 'sn_date', 1);

                }

            }

            $sermonNote = $sermonNote[0];

            //create sermon Note

            $content .= "<h2>" . $sermonNote['sn_title'] . "</h2>";

            $content .= '<p id="author">' . $sermonNote['sn_author'] . '</p>';

            $content .= '<p class="date">' . $sermonNote['sn_date'] . '</p>';

            $content .= $sermonNote['sn_content'];

            

            //create paging

			$content .= $this->snPagination($sermonNote['sn_id'], $type);

			

            

            return $content;

        }

        //display Sermon Note Menu

        public function displayMenu($id = null)

        {

            

            $sermonNotes = $this->select('sermonnotes', 'sn_id, sn_title, sn_date', 'sn_temp = 0 and note_type = 1' , 'sn_date DESC');

            if($id == null)

            {

                $id = $sermonNotes[0]['sn_id'];

            }

            //Get the names of each sermon Note

            $i=0;

            foreach ($sermonNotes as $sermonNote)

            {

                $i++;

                // display all the site previews

                ?>

                <li <?=($sermonNote['sn_id'] == $id ? "class='selectedMenuItem'" : "")?></li>

                        <a class="menuTitle" href="sermonNotes.php?sn=<?=$sermonNote['sn_id']?>"><?=$sermonNote['sn_title']?></a>

                        <p class="sndate"><?=$sermonNote['sn_date']?></p>

                </li>

                <?

                if ($i==10)

                    break;

            }

			?>

			<li  <?=($id == "va" ? "class='selectedMenuItem'" : "")?> >

				<a href="sermonNotes.php?sn=va">View All</a>

			</li>

			<?

        }

	//display Sermon Note Menu

        public function displayMenuPres($id = null, $type = 1)

        {

            

            $sermonNotes = $this->select('sermonnotes', 'sn_id, sn_title, sn_date', 'sn_temp = 0 and note_type = '. $type , 'sn_date DESC');

            if($id == null)

            { 

                $id = $sermonNotes[0]['sn_id'];

            }

            //Get the names of each sermon Note

            $i=0;

            foreach ($sermonNotes as $sermonNote)

            {

                $i++;

                // display all the site previews

                ?>

                <li <?=($sermonNote['sn_id'] == $id ? "class='selectedMenuItem'" : "")?></li>

                        <a class="menuTitle" href="<?=$_SERVER['PHP_SELF']?>?sn=<?=$sermonNote['sn_id']?>"><?=$sermonNote['sn_title']?></a>

                        <p class="sndate"><?=$sermonNote['sn_date']?></p>

                </li>

                <?

                if ($i==10 && $type != 3)

                    break;

            }

			if ($type!=3)  {?>

			<li  <?=($id == "va" ? "class='selectedMenuItem'" : "")?> >

				<a href="snp.php?sn=va">View All</a>

			</li>s

			<?}

        }

		//display Sermon Note Menu

        public function displayMenuTeachings($id = null)

        {

            $sermonNotes = $this->select('sermonnotes', 'sn_id, sn_title, sn_date', 'sn_temp = 0 and note_type = 2' , 'sn_date DESC');

            if($id == null)

            {

                $id = $sermonNotes[0]['sn_id'];

            }

            //Get the names of each sermon Note

            $i=0;

            foreach ($sermonNotes as $sermonNote)

            {

                $i++;

                // display all the site previews

                ?>

                <li <?=($sermonNote['sn_id'] == $id ? "class='selectedMenuItem'" : "")?></li>

                        <a class="menuTitle" href="teachings.php?sn=<?=$sermonNote['sn_id']?>"><?=$sermonNote['sn_title']?></a>

                        <p class="sndate"><?=$sermonNote['sn_date']?></p>

                </li>

                <?

                if ($i==10)

                    break;

            }

			?>

			<li  <?=($id == "va" ? "class='selectedMenuItem'" : "")?> >

				<a href="teachings.php?sn=va">View All</a>

			</li>

			<?

        }

        //display Sermon Note View All Page

        public function viewAll()

        {

			$theResult = "";

			$currentYear = -1;

			$currentMonth = -1;

			$first = true;

			$sermonNotes = $this->select('sermonnotes', 'sn_id, sn_title, sn_date', 'sn_temp = 0 and note_type = 1', 'sn_date DESC');

			$theResult .=' <ul id="viewAllMenu">';

			foreach ($sermonNotes as $sermonNote)

            {  

				if(date("Y", strtotime($sermonNote['sn_date'])) != $currentYear)

				{

					$currentYear = date("Y", strtotime($sermonNote['sn_date']));

					$currentMonth = date("F", strtotime($sermonNote['sn_date']));

					if(!$first)

					{

						//close last year's stuff

						

					$theResult .= "			</ul>

							</li>

						</ul>

					</li>";

					}

					$theResult .='

					<li  class="year" data-year="'.$currentYear.'">'.$currentYear.'</li>

					<li class="yearHolder '.($first ? "open" : "close").'" id="'.$currentYear.'">

						<ul>

							<li class="month" data-id="'.$currentMonth . $currentYear.'">'.$currentMonth.'</li>

							<li class="monthHolder open" id="'.$currentMonth . $currentYear.'">

								<ul>

									<li><a href="sermonNotes.php?sn='.$sermonNote['sn_id'].'">'.$sermonNote['sn_title']. ' (' . $sermonNote['sn_date']. ')</a></li>';		

					$first = false;

				}

				elseif(date("F", strtotime($sermonNote['sn_date'])) != $currentMonth)

				{

					$currentMonth = date("F", strtotime($sermonNote['sn_date']));

					$theResult .='

								</ul>

							</li>

							<li class="month" data-id="'.$currentMonth . $currentYear.'>">'.$currentMonth.'</li>

							<li class="monthHolder close" id="'.$currentMonth . $currentYear.'">

								<ul>

									<li><a href="sermonNotes.php?sn='.$sermonNote['sn_id'].'">'.$sermonNote['sn_title']. ' (' . $sermonNote['sn_date']. ')</a></li>';

					

				}

				else

				{

					$theResult .='

									<li><a href="sermonNotes.php?sn='.$sermonNote['sn_id'].'">'.$sermonNote['sn_title']. ' (' . $sermonNote['sn_date']. ')</a></li>';

				}

            }

			$theResult .='

								</ul>

							</li>

						</ul>

					</li>

				</ul>';

			

			return $theResult;

        }

	public function viewAllTeachings()

        {

			$theResult = "";

			$currentYear = -1;

			$currentMonth = -1;

			$first = true;

			$sermonNotes = $this->select('sermonnotes', 'sn_id, sn_title, sn_date', 'sn_temp = 0 and note_type = 2', 'sn_date DESC');

			$theResult .=' <ul id="viewAllMenu">';

			foreach ($sermonNotes as $sermonNote)

            {  

				if(date("Y", strtotime($sermonNote['sn_date'])) != $currentYear)

				{

					$currentYear = date("Y", strtotime($sermonNote['sn_date']));

					$currentMonth = date("F", strtotime($sermonNote['sn_date']));

					if(!$first)

					{

						//close last year's stuff

						

					$theResult .= "			</ul>

							</li>

						</ul>

					</li>";

					}

					$theResult .='

					<li  class="year" data-year="'.$currentYear.'">'.$currentYear.'</li>

					<li class="yearHolder '.($first ? "open" : "close").'" id="'.$currentYear.'">

						<ul>

							<li class="month" data-id="'.$currentMonth . $currentYear.'">'.$currentMonth.'</li>

							<li class="monthHolder open" id="'.$currentMonth . $currentYear.'">

								<ul>

									<li><a href="teachings.php?sn='.$sermonNote['sn_id'].'">'.$sermonNote['sn_title']. ' (' . $sermonNote['sn_date']. ')</a></li>';		

					$first = false;

				}

				elseif(date("F", strtotime($sermonNote['sn_date'])) != $currentMonth)

				{

					$currentMonth = date("F", strtotime($sermonNote['sn_date']));

					$theResult .='

								</ul>

							</li>

							<li class="month" data-id="'.$currentMonth . $currentYear.'>">'.$currentMonth.'</li>

							<li class="monthHolder close" id="'.$currentMonth . $currentYear.'">

								<ul>

									<li><a href="teachings.php?sn='.$sermonNote['sn_id'].'">'.$sermonNote['sn_title']. ' (' . $sermonNote['sn_date']. ')</a></li>';

					

				}

				else

				{

					$theResult .='

									<li><a href="teachings.php?sn='.$sermonNote['sn_id'].'">'.$sermonNote['sn_title']. ' (' . $sermonNote['sn_date']. ')</a></li>';

				}

            }

			$theResult .='

								</ul>

							</li>

						</ul>

					</li>

				</ul>';

			

			return $theResult;

        }

        //Return Json Sermon Note

        public function jsonSermonNote($id)

        {

            //get the sermon note

            $sermonNote = $this->select('sermonnotes', '*', "sn_id = $id");

            //ouput the sermon Note

            echo json_encode($sermonNote[0]);

        }

	//Return Json Sermon Note

        public function byID($id)

        {

            //get the sermon note

            $sermonNote = $this->select('sermonnotes', '*', "sn_id = $id");

            //ouput the sermon Note

            return $sermonNote;

        }

        //add a new sermon note

        public function addSermonNote($title, $author, $date, $content, $temp, $type)

        {

	    if(trim($author) == "")

	    {

		$author = null;

	    }

            $this->insert("sermonnotes", "null, '".$title."', '".$author."', '".$date."','".$content."', $temp, $type, 10");

        }

        //update an existing sermon Note

        public function updateSermonNote($id, $title, $author, $date, $content, $temp, $type)

        {

            $this->update("sermonnotes", "sn_title = '".$title."', sn_author = '". $author ."', sn_date = '".$date."', sn_content = '".$content."', sn_temp = $temp, note_type = $type", "sn_id=$id");

        }

        //return an array of all sermon Notes

        public function all()

        {

            $sermonNote = $this->select('sermonnotes', '*');

            //ouput the sermon notes

            return $sermonNote;

        }

        //sermon Notes Pagination

        public function snPagination($start, $type)

        {

            $count = $this->select('sermonnotes', 'COUNT(*)', 'sn_temp = 0 and note_type = '.$type);

            $countPlace = $this->select('sermonnotes', 'COUNT(*)', "sn_date <= (SELECT sn_date FROM sermonnotes WHERE sn_id = $start) and sn_temp = 0 and note_type = ". $type);

			

            $prev = $this->select('sermonnotes', 'sn_id', "sn_date <= (SELECT sn_date FROM sermonnotes WHERE sn_id = $start) and sn_id < $start and sn_temp = 0 and note_type = " . $type, 'sn_date DESC', 1);

            $next = $this->select('sermonnotes', 'sn_id', "sn_date >= (SELECT sn_date FROM sermonnotes WHERE sn_id = $start) and sn_id > $start and sn_temp = 0 and note_type = " . $type, 'sn_date ASC', 1);

            if($count == $countPlace and !empty($next))

				$countPlace[0][0] = $countPlace[0][0] - 1;

				

            //create Pagination.

            return "<div id='cFooter'>

                ".(!empty($prev)? "<a href='".($type == 1 ? 'sermonNotes.php' : 'teachings.php')."?sn=". $prev[0]['sn_id'] ."'>Previous</a>" : ""). "

                <p><span id='pageN'>".$countPlace[0][0]."</span> of <span id='pageC'>".$count[0][0]."</span></p>

                ".(!empty($next)? "<a href='".($type == 1 ? 'sermonNotes.php' : 'teachings.php')."?sn=". $next[0]['sn_id'] ."'>Next</a>" : ""). "

                <p id='tableName' style='display: none;'>sermonNotes</p>

            </div>";

        }

		 

        //seron Note Editing Selects

        public function snEditSelections($type="0")

        {

            $sermonNote = $this->select('sermonnotes', '*', 'note_type = 1', 'sn_date DESC');

	    $teachings = $this->select('sermonnotes', '*', 'note_type = 2', 'sn_date DESC');

	    $wSongs = $this->select('sermonnotes', '*', 'note_type = 3', 'sn_title ASC');

	    

            $editYear = "";

            $editMonth = "";

            $edit = "";

	    $editT = "";

	    $editS = "";

            $monthArray = array("Test");

            $yearArray = array("Test");

           

            foreach($sermonNote as $sn)

            {

                

                if(!in_array(date('Y', strtotime($sn['sn_date'])), $yearArray))

                {

                    $yearArray[] = date('Y', strtotime($sn['sn_date']));

                    $editYear .= "<option>" . date('Y', strtotime($sn['sn_date'])) . "</option>";

                }

                if(!in_array(date('m', strtotime($sn['sn_date'])), $monthArray))

                {

                    $monthArray[] = date('m', strtotime($sn['sn_date']));

                    $editMonth .= "<option>" . date('m', strtotime($sn['sn_date'])) . "</option>";

                }

                $edit .= "<option value='".$sn['sn_id']."'>" . $sn['sn_date'] . " - "  . $sn['sn_title'] . "</option>";

            }

	    foreach($teachings as $sn)

            {

                

                if(!in_array(date('Y', strtotime($sn['sn_date'])), $yearArray))

                {

                    $yearArray[] = date('Y', strtotime($sn['sn_date']));

                    $editYear .= "<option>" . date('Y', strtotime($sn['sn_date'])) . "</option>";

                }

                if(!in_array(date('m', strtotime($sn['sn_date'])), $monthArray))

                {

                    $monthArray[] = date('m', strtotime($sn['sn_date']));

                    $editMonth .= "<option>" . date('m', strtotime($sn['sn_date'])) . "</option>";

                }

                $editT .= "<option value='".$sn['sn_id']."'>" . $sn['sn_date'] . " - "  . $sn['sn_title'] . "</option>";

            }

	    foreach($wSongs as $sn)

            {

                

                if(!in_array(date('Y', strtotime($sn['sn_date'])), $yearArray))

                {

                    $yearArray[] = date('Y', strtotime($sn['sn_date']));

                    $editYear .= "<option>" . date('Y', strtotime($sn['sn_date'])) . "</option>";

                }

                if(!in_array(date('m', strtotime($sn['sn_date'])), $monthArray))

                {

                    $monthArray[] = date('m', strtotime($sn['sn_date']));

                    $editMonth .= "<option>" . date('m', strtotime($sn['sn_date'])) . "</option>";

                }

                $editS .= "<option value='".$sn['sn_id']."'>" . $sn['sn_title'] . "</option>";

            }

	    if($type==0)

	   {

            ?>

			<!--

            <select id='editYear' name="editYear" selected="selected">

                <option value="-1">YYYY</option> -->

                <?

                 // echo $edityear;

                ?>

           <!-- </select>

            <select id='editMonth' name="editMonth" selected="selected">

                <option value="-1">MM</option>-->

                <?

                 // echo $editMonth;

                ?>

           <!-- </select> -->

	   

            <div id="editContainer">

			</br>

				<span>Sermon Notes: </span></br>

                <select id="edit" name="edit" class="edit" selected="selected">

                    <option value="-1">Choose A Sermon Note To Edit</option>

                    <?

                    echo $edit;

                   ?>

                </select>

				</br></br><span>Teachings: </span></br>

                <select id="editT" name="editT" class="edit"  selected="selected">

                    <option value="-1">Choose A Teachings To Edit</option>

                    <?

                    echo $editT;

                   ?>

                </select>

            </div><br /></br>

            <?

	   }

	   elseif($type==3)

	   {

	    ?>

		<div id="editContainer">

		    <label>Songs: </label>

		    <select id="editS" name="editS" class="edit"  selected="selected">

			<option value="-1">Choose A Song To Edit</option>

			<?

			echo $editS;

		       ?>

		    </select>

		</div>

	    <?

	   }

        }

        //seron Note Editing Selects

        public function snEditSelectionByLimiter($year, $month = null)

        {

            if($year == null)

                $year = date('Y');

            if($month == null)

            {

                $start_date = "$year-01-01";

                $end_date = "$year-12-31";

            }

            else

            {

                

                $start_date = "$year-$month-01";

                $end_date = "$year-$month-31";

            }

            

            $sermonNote = $this->select('sermonnotes', '*', "where sn_date >= '".$start_date."' and sn_date <= '".$end_date."'", 'sn_date DESC', 1);

            $edit = "";

            foreach($sermonNote as $sn)

            {

                $edit .= "<option value='".$sn['sn_id']."'>" . $sn['sn_date'] . " - "  . $sn['sn_title'] . "</option>";

            }

           

            ?>

            <select id="edit" name="edit" selected="selected">

                <option value="-1">Choose A Sermon Note To Edit</option>

                <?

                 echo $edit;

                ?>

            </option>;

            <?

        }

	//Make a list of all the songs

	public function worshipSongsMenu($filter = ""){

	    

	    if(trim($filter) != "")

	    {

		$filterString = " and (sn_title LIKE '%$filter%' or sn_content LIKE '%$filter%')";

	    }

	    else

	    {

		$filterString = "";

	    }

	    $sermonNotes = $this->select('sermonnotes', 'sn_id, sn_title, tag_id', "(sn_temp = 0 and note_type = 3)" . $filterString, 'tag_id, sn_title');

            

	    //Get the names of each sermon Note 2.5

	    if($sermonNotes == "")

	    {

		echo "empty";

	    }

            $i=0;

	    $count = count($sermonNotes)+6;

	    if($count < 9)

	    {

		$numCol = 2;

		$numberInEach = ceil($count/2);

	    }

	    else

	    {

		$numCol = 3;

		$numberInEach = ceil($count/3);

	    }



	    

	    echo "<div data-numCol='". $numCol ."' class='column'> <ul>";

	    $currentTag = -1;

	    $tagArray = array(

			      0=>"Unknown",

			      1=>"Kerry",

			      2=>"Danny",

			      3=>"Danny or Kerry",

			      4=>"Really Not",

			      5=>"Philip & Marie",

			      6=>"Songs for Yahweh",

			      7=>"Brooke"

			      );

	 

            foreach ($sermonNotes as $sermonNote)

            {

                $i++;

                // display all the site previews

		if($currentTag != $sermonNote['tag_id'])

		{

		    

		    $currentTag = $sermonNote['tag_id'];

		

		    ?>

		    <li data-numCol="<?=$sermonNote['sn_id']?>">

			<b><?=$tagArray[$currentTag]?></b>

		    </li>

		    <?

		    $i++;

		}

                ?>

                <li data-numCol="<?=$sermonNote['sn_id']?>">

                    <?=$sermonNote['sn_title']?>

                </li>

                <?

		if($i >= $numberInEach)

		{

		    echo "</ul></div>";

		    if($i !== $numCol*$numberInEach)

		    {

			echo "<div class='column'></ul>";

		    }

		    $numberInEach = $numberInEach + $numberInEach;

		}

		

	    }

	    

		echo "</ul></div>";

	    

	}

}

?>