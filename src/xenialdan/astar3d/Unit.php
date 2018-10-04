<?php

namespace xenialdan\astar3d;

use pocketmine\level\Position;
use pocketmine\math\Vector3;

class Unit
{

/** @var Position */public $target;
/** @var float */public $speed = 3;
/** @var bool */public $showPath = false;

/** @var Vector3[]*/ private $path = [];
/** @var int */private $targetIndex;

    // Use this for initialization
public function Start () {
yield;
yield;
yield;
    PathRequestManager::RequestPath(transform.position, target.position, OnPathReceived);
}

public function Update () :void{
		//if (Input.GetKeyUp(KeyCode.A)) {
        //    if (GameObject.Find("A*").GetComponent<Grid>()) {
                //Debug.Log(GameObject.Find("A*").GetComponent<Grid>().NodeFromWorldPoint(transform.position).gridPosition);
    //PathRequestManager::RequestPath(transform.position, target.position, OnPathReceived);
        //    }
		//}
	}

	public function OnPathReceived ($newPath, bool $success) {
    if ($success) {
        $this->path = $newPath;
        StopCoroutine("FollowPath");
        StartCoroutine("FollowPath");
    }
}

private function FollowPath ():\Generator {
/**@var Vector3 */$currentWaypoint = $this->path[0];

		while (true) {
            if ($this == $currentWaypoint) {
                $targetIndex++;
                if ($targetIndex >= count($this->path)) {
                    yield;
				}
                $currentWaypoint = $this->path[$targetIndex];
            }
            transform.position = Vector3.MoveTowards(transform.position, currentWaypoint, speed*Time.deltaTime);
            yield;
		}
	}
}
