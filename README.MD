# PocketAI
##### PocketMine-MP A\* Mob-AI plugin with addon support
PocketAI was written with the intention to load Minecraft Pocket/Bedrock/Unified Edition addons in PocketMine-MP servers and adapting the client entity behaviour to server entities.

Addons are behaviour changing "scripts" introduced into the XBL-Edition of the game.

This addon uses an A* (astar) algorithm for performance-friendly, but still quite advanced pathfinding.

## Setup / usage
You need to download a __vanilla Minecraft addon__ for the current version of the game/server from
https://minecraft.net (https://aka.ms/behaviorpacktemplate) or extract it from your game
and install it as resource pack on your PocketMine-MP server.

_Please look up
https://forums.pmmp.net if you don't know how to install resource packs in PocketMine-MP_

Install the plugin into the /plugins folder of your server

## Disclaimer
**PocketAI is HIGHLY EXPERIMENTAL** - it may crash your server or corrupt your data! Use at your own risk!

_(Reason: entities & data saving methods like NBT are not fully backwards-compatible with changes done in PocketMine-MP or Minecraft. Changes may happen at any time.)_

## Progress
- [x] Load the addon
- [x] Add components & component groups (behaviour controllers)
- [ ] Add behaviour listeners
- [x] Add automated addon events
- [ ] Add event listeners
- [ ] Create spawning algorithm
- [ ] Implement A\* algorithm (3D)
- [ ] Pathfinding (Async, path goals, modifiers, avoiders)
- [ ] Entity inventories / inventory handling
- [ ] All base entities
- [ ] Interfaces
- [ ] Commands