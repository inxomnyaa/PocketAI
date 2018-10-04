

/* behaviour checks */

$deltaMovement = new Vector3();
//for mobs x and z are used for pitch and yaw, and y is used for headyaw
$deltaRotation = new Vector3();//TODO correct fields
if (!is_null($this->getEntityProperties())) {

//MOVEMENT BASIC
/** @var _basic $basicMovementComponent */
if ($this->getEntityProperties()->hasComponent("minecraft:movement.basic"))
$basicMovementComponent = $this->getEntityProperties()->findComponents("minecraft:movement.basic")->pop();
else
$basicMovementComponent = new _basic();

//MOVEMENT RANDOM LOOK AROUND
if (mt_rand(0, 20 * 5) === 30) {
if ($this->getEntityProperties()->hasComponent("minecraft:behavior.random_look_around")) {
$deltaRotation->z += (mt_rand(-intval($basicMovementComponent->max_turn * 100), intval($basicMovementComponent->max_turn * 100)) / 100);
}
}

if ($this->getEntityProperties()->hasComponent("minecraft:behavior.move_towards_restriction")) {
/** @var _move_towards_restriction $component */
$component = $this->getEntityProperties()->findComponents("minecraft:behavior.move_towards_restriction")->pop();
if ($this->getEntityProperties()->hasComponent("minecraft:leashable")) {
$hardDistance = PHP_INT_MAX;
/** @var _leashable $leashable */
foreach ($this->getEntityProperties()->findComponents("minecraft:leashable") as $leashable) {
if ($leashable->hard_distance < $hardDistance) $hardDistance = $leashable->hard_distance;
}
$towards = $this->getLeadHolder();
if ($towards instanceof Entity && $this->distanceSquared($towards) >= $hardDistance ** 2) {
$steps = 10;
$pos = $this->asVector3();
for($i = 0; $i < $steps; $i++){
$this->getLevel()->addParticle(new WaterParticle($pos));
$pos = $pos->subtract(($this->getX()-$towards->getX())/$steps,($this->getY()-$towards->getY())/$steps,($this->getZ()-$towards->getZ())/$steps);
}
$motion = $towards->subtract($this)->normalize();
$deltaMovement = $deltaMovement->add($motion->multiply($this->getDefaultSpeed() * 4)->multiply($component->speed_multiplier));//TODO fix speed
}
$hasUpdate = true;
}
}

$this->setMotion($this->getMotion()->add($deltaMovement->multiply($tickDiff)));
$this->setRotation($deltaMovement->getZ() % 360, API::clamp($deltaMovement->getX(), -90, 90));
$hasUpdate = true;
}