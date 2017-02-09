@extends('layout')

@section('title')
    Edmonton Ward 12 By-Election
@stop

@section('content')

    <h1>{{ $election->name }} <small style="color:goldenrod">{{ $election_date->format('M j, Y') }}</small></h1>
	<div class="whitecard">
        @if (! $election->isFinished())
            Vote in {{ $election->daysLeft() }} days.
        @else
            Election finished!
        @endif
    </div>
    <div class="flex-justified" style="text-align: center;">
        <div class="column">
            <div class="whitecard">
                <h3>About YEGVOTES.info</h3>
                <p>
                    <a href="https://yegvotes.info/about">YEGVotes.info</a> is a site run by <a href="http://tpavlek.me">Troy Pavlek</a>.
                    It's chief purpose uses the Edmonton Open Data Catalogue to keep track of City Council voting records.
                    However, during election time it provides an easy way for anyone to keep track of who is running.
                </p>

                <p>
                    If there is data you want aggregated, or if you notice incorrect data, please let me know through one of
                    the contact options below.
                </p>
                <p>
                    <a href="https://twitter.com/troypavlek" class="button"><i class="fa fa-twitter"></i> Tweet @troypavlek</a>
                    <a href="mailto:troy@tpavlek.me?subject=YEGVotes 2017 Election Feedback" class="button"><i class="fa fa-envelope"></i> Email troy@tpavlek.me</a>
                </p>
            </div>
        </div>

    </div>

    <div class="flex-justified">

        <div id="ward-map" class="whitecard">
            <h2>Select a Ward</h2>
        </div>

        <style>

            path {
                stroke-width: 1px;
                stroke: #ffffff;
                fill: #9fd3fc;
                cursor: pointer;
            }

            path:hover, path.highlighted {
                fill: tomato;
            }

            div.tooltip {
                position: absolute;
                background-color: white;
                border: 1px solid black;
                color: black;
                font-weight: bold;
                padding: 4px 8px;
                display: none;
            }

        </style>
        <script src="http://d3js.org/d3.v3.min.js"></script>
        <script>

            //Map dimensions (in pixels)
            var width = 492,
                height = 600;

            //Map projection
            var projection = d3.geo.mercator()
                .scale(60529.17400840133)
                .center([-113.49270197735584,53.55596537299996]) //projection center
                .translate([width/2,height/2]) //translate to center the map in view

            //Generate paths based on projection
            var path = d3.geo.path()
                .projection(projection);

            //Create an SVG
            var svg = d3.select("#ward-map").append("svg")
                .attr("width", width)
                .attr("height", height);

            //Group for the map features
            var features = svg.append("g")
                .attr("class","features");

            //Create a tooltip, hidden at the start
            var tooltip = d3.select("body").append("div").attr("class","tooltip");

            d3.json("/data/ward-boundaries.geojson",function(error,geodata) {
                if (error) return console.log(error); //unknown error, check the console

                //Create a path for each map feature in the data
                features.selectAll("path")
                    .data(geodata.features)
                    .enter()
                    .append("path")
                    .attr("d",path)
                    .on("mouseover",showTooltip)
                    .on("mousemove",moveTooltip)
                    .on("mouseout",hideTooltip)
                    .on("click",clicked);

            });

            // Add optional onClick events for features here
            // d.properties contains the attributes (e.g. d.properties.name, d.properties.population)
            function clicked(d,i) {
                var ward = d.properties.name.substring(5);

                window.location = window.location + '/ward/' + ward;
            }


            //Position of the tooltip relative to the cursor
            var tooltipOffset = {x: 5, y: -25};

            //Create a tooltip, hidden at the start
            function showTooltip(d) {
                moveTooltip();

                tooltip.style("display","block")
                    .text(d.properties.name);
            }

            //Move the tooltip to track the mouse
            function moveTooltip() {
                tooltip.style("top",(d3.event.pageY+tooltipOffset.y)+"px")
                    .style("left",(d3.event.pageX+tooltipOffset.x)+"px");
            }

            //Create a tooltip, hidden at the start
            function hideTooltip() {
                tooltip.style("display","none");
            }
        </script>



    </div>



@stop
