<?php

require_once("config.php");
require_once('database.php');
/*
mowing_piece
     -description
     -id
     -isActive
     -isRequired
mowing_week
    -amountOwed
    -bigHillCompleted
    -id
    -isComplete
    -isPaid
    -weekStartDate
mowed
    -id
    -isMowed
    -piece_id
    -week_id
*/
class mowing extends database
{
    //Return Json Sermon Note
    public function jsonSermonNote($id)
    {
        $date = strtotime('last Sunday');
        $mowing_week = $this->select('mowing_week, mowed, mowing_piece', '*', "mowing_week.id = mowed.week_id AND mowed.piece_id = mowing_piece.id AND weekStartDate = " + $date);
        if($mowing_week.isnull){
            $this->initializeMowingWeek();
            $mowing_week = $this->select('mowing_week, mowed, mowing_piece', '*', "mowing_week.id = mowed.week_id AND mowed.piece_id = mowing_piece.id AND weekStartDate = " + $date);
        }
        echo json_encode($mowing_week[0]);
    }

   //Return Json Sermon Note
    public function byID($id)
    {
        $sermonNote = $this->select('sermonnotes', '*', "sn_id = $id");
        return $sermonNote;
    }

    public function initializeMowingWeek()
    {
        $date = strtotime('last Sunday');

        $mowing_week = $this->insert("mowing_week", "0, null, null, null, null, " + $date);

        $mowingPieces = $this->select('mowing_piece', '*', "isActive = true");
        foreach($mp in $mowingPieces){
            $this->insert("mowed", "null, null, "  + $mp['id'] + ", " + $mowing_week['id']);
        }
    }

    //update an existing sermon Note
    public function updateSermonNote($id, $title, $author, $date, $content, $temp, $type)
    {
        $this->update("sermonnotes", "sn_title = '".$title."', sn_author = '". $author ."', sn_date = '".$date."', sn_content = '".$content."', sn_temp = $temp, note_type = $type", "sn_id=$id");
    }
}

?>