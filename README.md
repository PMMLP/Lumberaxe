# Lumberaxe
🪓 Lumberaxe plugin for PocketMine-MP V4.*

# Features

```
✅️ Highly configurable
✅️ Good performance
✅️ Easy to use
✅️ Chop down trees extremly fast
✅️ Fast leaves decay
✅️ Support for custom recipe
✅️ Custom axe texture
✅️ Made with 💖
```

# Note
This plugin needs a [resource pack](https://github.com/PMMLP/Lumberaxe/releases/download/V1.0.0/Lumberaxe-RP.zip) to work

# Requires

[libPMMLP](https://github.com/PMMLP/libPMMLP)

# Screenshots
|                                                                         | | |
|:-----------------------------------------------------------------------:|:---:|:---:|
| ![Recipe](https://github.com/PMMLP/Lumberaxe/blob/V1.0.0/images/default_recipe.png) |![Texture](https://github.com/PMMLP/Lumberaxe/blob/V1.0.0/images/lumberaxe_texture.png)|![Chopping](https://github.com/PMMLP/Lumberaxe/blob/V1.0.0/images/lumberaxe_chopping.png)|

# Config

```
# Set the maximum amount of blocks an axe can break with one chop (Higher value => More CPU usage)
maxBlocksToBreak: 24

# Set if leaves should decay fast. Amount of ticks can be configured in 'maxLeavesDecayTicks' (1 second = 20 ticks)
fastLeavesDecay: true
maxLeavesDecayTicks: 60

# When false, axe only takes one damage per chop
damageAxeForEachBlock: true

# Set to false if you don`t want the recipe to be registered and used
registerRecipe: true

# Set a custom recipe. Wouldn`t recommend to change it if you don`t have an idea of what you`re doing
recipe:
  items:
    A: 280::0
    B: 264::0
    C: 388::0
  shaped: true
  shape:
  - 'BCB'
  - 'BA '
  - ' A '

# Do not touch!
version: 1.0.0

```

# Donate

_Soon..._

# Credits
Made by Matze, Dezember 2022