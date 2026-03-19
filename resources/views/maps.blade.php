<x-maps-google
    :markers="[
        ['lat' => 46.056946, 'long' => 14.505752],
        ['lat' => 41.902782, 'long' => 12.496365]
    ]"            
    :fitToBounds="true"
></x-maps-google>

// Position the map's center at the geometric midpoint of all markers:
<x-maps-google
    :markers="[
        ['lat' => 46.056946, 'long' => 14.505752],
        ['lat' => 41.902782, 'long' => 12.496365]
    ]"            
    :centerToBoundsCenter="true"
    :zoomLevel="7"
></x-maps-google>