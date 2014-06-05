<p>
    In many projects I’ve worked on that resembled games, the movement was always the wall I’d hit and couldn’t get over. I often tried to dive head first, and reinvent the wheel with real physics, collision detection, proper resolution and so on. It was so overwhelming whenever I had previously attempted that I would end up disbanding the project.
</p>
<p>
    This time I took a step back and thought “the movement for this game doesn’t have to be complex. There’s no real time combat, there’s no need to go diagonal.” I decided I would make the movement much like the ever so popular Pokemon games. You move tile to tile, one at a time. You can never occupy more than one tile at a time, and you can’t go diagonal.
</p>
<p>
    This method of moving around the world became very easy to program. Collision was as simple as checking to see if the tile the player was trying to move into was occupied tile (by another entity), or was a “blocked” tile ID. While moving between tiles, I did a simple linear interpolation which allowed for a smooth, continuous walking movement if a player was to hold down a movement key.
</p>
<p>
    This method still allows for everything I needed: the ability to interact with other entities, go through “transportation/teleport” tiles, trigger combat and last but not least look good. With help from Julie, I think this game will end up looking great.
</p>
<p>
    On a side note, I’ve also finally caught up on JavaDoc for all my code in addition to updating my current UML map. All of which can be found (including the current build of the game) on the project page: Click Here.
</p>
