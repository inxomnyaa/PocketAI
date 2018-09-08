<?php


namespace xenialdan\astar3d;


use pocketmine\math\Vector3;

class PathRequestManager
{


    /** @var \SplQueue<PathRequest> */ public $pathRequestQueue;
    /** @var PathRequest */ public $currentPathRequest;

/** @var Pathfinder */ public $pathfinder;
/** @var bool */ public $isProcessingPath;

static PathRequestManager instance;

void Awake () {
instance = this;
pathfinder = GetComponent<Pathfinder>();
}

struct PathRequest {
    /** @var Vector3 */public $pathStart;
			public Vector3 $pathEnd;
	/** @var Vector3 */		public Action<Vector3[], bool> callback;

			public PathRequest (Vector3 _pathStart, Vector3 _pathEnd, Action<Vector3[], bool> _callback) {
        pathStart = _pathStart;
        pathEnd = _pathEnd;
        callback = _callback;
    }
		}

		public static function RequestPath (Vector3 $pathStart, Vector3 $pathEnd, callable $callback) :void{
    PathRequest newRequest = new PathRequest(pathStart, pathEnd, callback);
			instance.pathRequestQueue.Enqueue(newRequest);
			instance.TryProcessNext();
		}

		void TryProcessNext () {
			if (!isProcessingPath && pathRequestQueue.Count > 0) {
                currentPathRequest = pathRequestQueue.Dequeue();
                isProcessingPath = true;
                pathfinder.StartFindingPath(currentPathRequest.pathStart, currentPathRequest.pathEnd);
            }
		}

		public void FinishedProcessingPath (Vector3[] path, bool success) {
    currentPathRequest.callback(path, success);
    isProcessingPath = false;
    TryProcessNext();
}
	}
}