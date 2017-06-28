@extends('layout')

@section('title', "{$election->name} -" )

@section('meta_description', "Track everyone running in the 2017 General Election on YEGVotes.info")

@section('meta_image', '/img/election/2017/election-map.png')

@section('content')

    <h1>{{ $election->name }} <small style="color:goldenrod">{{ $election->date->format('M j, Y') }}</small></h1>
	<div class="whitecard">
        @if (! $election->isFinished())
            Vote in {{ $election->daysLeft() }} days.
        @else
            Election finished!
        @endif
    </div>

    <div class="flex-justified">

        <div class="whitecard">
            <h2>Select a Ward</h2>
            <div id="ward-map"></div>
            <h2>Or choose a neighbourhood</h2>
            <select id="neighbourhood-select">
                <option value="">Select a Neighbourhood</option>
                <option value='7'>Alberta Avenue</option>
                <option value='6'>Boyle Street</option>
                <option value='6'>Central Mcdougall</option>
                <option value='7'>Cromdale</option>
                <option value='7'>Delton</option>
                <option value='6'>Downtown</option>
                <option value='7'>Eastwood</option>
                <option value='2'>Edmonton Municipal Airport</option>
                <option value='7'>Edmonton Northlands</option>
                <option value='7'>Elmwood Park</option>
                <option value='6'>Mccauley</option>
                <option value='6'>Oliver</option>
                <option value='7'>Parkdale</option>
                <option value='2'>Prince Rupert</option>
                <option value='6'>Queen Mary Park</option>
                <option value='7'>River Valley Kinnaird</option>
                <option value='6'>River Valley Victoria</option>
                <option value='6'>Riverdale</option>
                <option value='6'>Rossdale</option>
                <option value='2'>Spruce Avenue</option>
                <option value='7'>Virginia Park</option>
                <option value='2'>Westwood</option>
                <option value='7'>Yellowhead Corridor East</option>
                <option value='2'>Yellowhead Corridor West</option>
                <option value='7'>Abbottsfield</option>
                <option value='7'>Balwin</option>
                <option value='4'>Bannerman</option>
                <option value='7'>Beacon Heights</option>
                <option value='3'>Belle Rive</option>
                <option value='7'>Bellevue</option>
                <option value='4'>Belmont</option>
                <option value='4'>Belvedere</option>
                <option value='7'>Bergman</option>
                <option value='7'>Beverly Heights</option>
                <option value='4'>Brintnell</option>
                <option value='4'>Canon Ridge</option>
                <option value='4'>Casselman</option>
                <option value='4'>Clareview Town Centre</option>
                <option value='4'>Clover Bar Area</option>
                <option value='7'>Delwood</option>
                <option value='3'>Eaux Claires</option>
                <option value='4'>Ebbers</option>
                <option value='3'>Evansdale</option>
                <option value='4'>Evergreen</option>
                <option value='4'>Fraser</option>
                <option value='7'>Glengarry</option>
                <option value='4'>Gorman</option>
                <option value='4'>Hairsine</option>
                <option value='7'>Highlands</option>
                <option value='4'>Hollick-kenyon</option>
                <option value='4'>Homesteader</option>
                <option value='7'>Industrial Heights</option>
                <option value='4'>Kennedale Industrial</option>
                <option value='4'>Kernohan</option>
                <option value='7'>Kildare</option>
                <option value='3'>Kilkenny</option>
                <option value='7'>Killarney</option>
                <option value='4'>Kirkness</option>
                <option value='3'>Klarvatten</option>
                <option value='3'>Lago Lindo</option>
                <option value='3'>Crystallina Nera East</option>
                <option value='4'>Matt Berry</option>
                <option value='3'>Mayliewan</option>
                <option value='4'>Mcconachie Area</option>
                <option value='4'>Mcleod</option>
                <option value='4'>Miller</option>
                <option value='7'>Montrose</option>
                <option value='7'>Newton</option>
                <option value='7'>Northmount</option>
                <option value='4'>Overlanders</option>
                <option value='3'>Ozerna</option>
                <option value='4'>Cy Becker</option>
                <option value='4'>River Valley Hermitage</option>
                <option value='7'>River Valley Highlands</option>
                <option value='7'>River Valley Rundle</option>
                <option value='7'>Rundle Heights</option>
                <option value='4'>Rural North East Horse Hill</option>
                <option value='4'>Rural North East South Sturgeon</option>
                <option value='3'>Schonsee</option>
                <option value='4'>Sifton Park</option>
                <option value='4'>York</option>
                <option value='2'>Athlone</option>
                <option value='2'>Baranow</option>
                <option value='3'>Baturyn</option>
                <option value='3'>Beaumaris</option>
                <option value='2'>Brown Industrial</option>
                <option value='2'>Caernarvon</option>
                <option value='2'>Calder</option>
                <option value='3'>Canossa</option>
                <option value='2'>Carlisle</option>
                <option value='2'>Griesbach</option>
                <option value='3'>Chambery</option>
                <option value='1'>Crestwood</option>
                <option value='2'>Cumberland</option>
                <option value='2'>Dominion Industrial</option>
                <option value='2'>Dovercourt</option>
                <option value='3'>Dunluce</option>
                <option value='3'>Elsinore</option>
                <option value='6'>Glenora</option>
                <option value='6'>Grovenor</option>
                <option value='2'>Hagmann Estate Industrial</option>
                <option value='2'>Huff Bremner Estate Industrial</option>
                <option value='2'>Inglewood</option>
                <option value='2'>Kensington</option>
                <option value='2'>Lauderdale</option>
                <option value='5'>Laurier Heights</option>
                <option value='3'>Lorelei</option>
                <option value='2'>Mcarthur Industrial</option>
                <option value='6'>Mcqueen</option>
                <option value='6'>North Glenora</option>
                <option value='2'>Oxford</option>
                <option value='1'>Parkview</option>
                <option value='2'>Pembina</option>
                <option value='2'>Prince Charles</option>
                <option value='2'>Rampart Industrial</option>
                <option value='3'>Rapperswill</option>
                <option value='1'>River Valley Capitol Hill</option>
                <option value='6'>River Valley Glenora</option>
                <option value='5'>River Valley Laurier</option>
                <option value='2'>Rosslyn</option>
                <option value='2'>Sherbrooke</option>
                <option value='2'>Wellington</option>
                <option value='6'>Westmount</option>
                <option value='2'>Woodcroft</option>
                <option value='2'>Albany</option>
                <option value='2'>Carlton</option>
                <option value='2'>Hudson</option>
                <option value='2'>Goodridge Corners</option>
                <option value='1'>Alberta Park Industrial</option>
                <option value='1'>Anthony Henday</option>
                <option value='5'>Anthony Henday South West</option>
                <option value='9'>Anthony Henday Terwillegar</option>
                <option value='9'>Anthony Henday South</option>
                <option value='2'>Anthony Henday Mistatim</option>
                <option value='3'>Anthony Henday Castledowns</option>
                <option value='3'>Anthony Henday Lake District</option>
                <option value='1'>Anthony Henday Big Lake</option>
                <option value='4'>Anthony Henday Energy Park</option>
                <option value='1'>Aldergrove</option>
                <option value='4'>Anthony Henday Horse Hill</option>
                <option value='4'>Anthony Henday Clareview</option>
                <option value='2'>Anthony Henday Rampart</option>
                <option value='1'>Armstrong Industrial</option>
                <option value='1'>Belmead</option>
                <option value='2'>Bonaventure Industrial</option>
                <option value='1'>Britannia Youngstown</option>
                <option value='5'>Callingwood North</option>
                <option value='5'>Callingwood South</option>
                <option value='1'>Canora</option>
                <option value='1'>Carleton Square Industrial</option>
                <option value='5'>Dechene</option>
                <option value='5'>Donsdale</option>
                <option value='1'>Edmiston Industrial</option>
                <option value='5'>Elmwood</option>
                <option value='2'>Gagnon Estate Industrial</option>
                <option value='5'>Gariepy</option>
                <option value='2'>Garside Industrial</option>
                <option value='1'>Glenwood</option>
                <option value='1'>Hawin Park Estate Industrial</option>
                <option value='1'>High Park</option>
                <option value='2'>High Park Industrial</option>
                <option value='5'>Jamieson Place</option>
                <option value='1'>Jasper Park</option>
                <option value='1'>La Perle</option>
                <option value='5'>Lymburn</option>
                <option value='5'>Lynnwood</option>
                <option value='1'>Mayfield</option>
                <option value='1'>Mcnamara Industrial</option>
                <option value='1'>Meadowlark Park</option>
                <option value='2'>Mistatim Industrial</option>
                <option value='2'>Mitchell Industrial</option>
                <option value='1'>Morin Industrial</option>
                <option value='1'>Norwester Industrial</option>
                <option value='5'>Oleskiw</option>
                <option value='5'>Ormsby Place</option>
                <option value='5'>Patricia Heights</option>
                <option value='1'>Place Larue</option>
                <option value='1'>Poundmaker Industrial</option>
                <option value='5'>Quesnell Heights</option>
                <option value='5'>Rio Terrace</option>
                <option value='5'>River Valley Lessard North</option>
                <option value='5'>River Valley Oleskiw</option>
                <option value='5'>The Hamptons</option>
                <option value='5'>Edgemont</option>
                <option value='5'>Cameron Heights</option>
                <option value='5'>River Valley Cameron</option>
                <option value='1'>Rural West Big Lake</option>
                <option value='1'>Trumpeter Area</option>
                <option value='1'>Hawks Ridge</option>
                <option value='1'>Starling</option>
                <option value='1'>Kinokamau Plains Area</option>
                <option value='1'>Lewis Farms Industrial</option>
                <option value='1'>Stewart Greens</option>
                <option value='1'>Secord</option>
                <option value='1'>Sheffield Industrial</option>
                <option value='1'>Sherwood</option>
                <option value='1'>Stone Industrial</option>
                <option value='1'>Summerlea</option>
                <option value='1'>Sunwapta Industrial</option>
                <option value='1'>Terra Losa</option>
                <option value='5'>Granville</option>
                <option value='5'>Thorncliff</option>
                <option value='5'>Wedgewood Heights</option>
                <option value='1'>West Jasper Place</option>
                <option value='1'>West Meadowlark Park</option>
                <option value='1'>West Sheffield Industrial</option>
                <option value='5'>Westridge</option>
                <option value='1'>Westview Village</option>
                <option value='1'>White Industrial</option>
                <option value='1'>Wilson Industrial</option>
                <option value='1'>Winterburn Industrial Area East</option>
                <option value='1'>Youngstown Industrial</option>
                <option value='1'>Winterburn Industrial Area West</option>
                <option value='1'>Breckenridge Greens</option>
                <option value='1'>Potter Greens</option>
                <option value='5'>Glastonbury</option>
                <option value='1'>Suder Greens</option>
                <option value='1'>Webber Greens</option>
                <option value='1'>Rosenthal</option>
                <option value='10'>Allendale</option>
                <option value='10'>Aspen Gardens</option>
                <option value='10'>Bearspaw</option>
                <option value='8'>Belgravia</option>
                <option value='10'>Blackmud Creek Ravine</option>
                <option value='10'>Blue Quill</option>
                <option value='10'>Blue Quill Estates</option>
                <option value='9'>Brander Gardens</option>
                <option value='9'>Brookside</option>
                <option value='9'>Bulyea Heights</option>
                <option value='10'>Calgary Trail North</option>
                <option value='10'>Calgary Trail South</option>
                <option value='9'>Carter Crest</option>
                <option value='8'>Strathcona Junction</option>
                <option value='10'>Duggan</option>
                <option value='10'>Empire Park</option>
                <option value='10'>Ermineskin</option>
                <option value='9'>Falconer Heights</option>
                <option value='8'>Garneau</option>
                <option value='10'>Grandview Heights</option>
                <option value='10'>Greenfield</option>
                <option value='9'>Henderson Estates</option>
                <option value='10'>Keheewin</option>
                <option value='10'>Lansdowne</option>
                <option value='10'>Lendrum Place</option>
                <option value='10'>Malmo Plains</option>
                <option value='8'>Mckernan</option>
                <option value='9'>Ogilvie Ridge</option>
                <option value='10'>Parkallen</option>
                <option value='10'>Pleasantview</option>
                <option value='8'>Queen Alexandra</option>
                <option value='9'>Ramsay Heights</option>
                <option value='9'>Rhatigan Ridge</option>
                <option value='10'>Rideau Park</option>
                <option value='8'>River Valley Mayfair</option>
                <option value='9'>River Valley Terwillegar</option>
                <option value='10'>River Valley Whitemud</option>
                <option value='9'>River Valley Fort Edmonton</option>
                <option value='9'>River Valley Windermere</option>
                <option value='10'>Royal Gardens</option>
                <option value='9'>Richford</option>
                <option value='9'>Macewan</option>
                <option value='9'>Blackmud Creek</option>
                <option value='9'>Rutherford</option>
                <option value='9'>Heritage Valley Area</option>
                <option value='9'>Callaghan</option>
                <option value='9'>Allard</option>
                <option value='10'>Skyrattler</option>
                <option value='9'>Chappelle Area</option>
                <option value='9'>Desrochers Area</option>
                <option value='9'>Heritage Valley Town Centre Area</option>
                <option value='9'>Hays Ridge Area</option>
                <option value='9'>Cashman</option>
                <option value='10'>Steinhauer</option>
                <option value='9'>Magrath Heights</option>
                <option value='9'>Mactaggart</option>
                <option value='8'>Strathcona</option>
                <option value='10'>Sweet Grass</option>
                <option value='9'>Ambleside</option>
                <option value='9'>Twin Brooks</option>
                <option value='8'>University Of Alberta</option>
                <option value='10'>University Of Alberta Farm</option>
                <option value='10'>Westbrook Estates</option>
                <option value='10'>Whitemud Creek Ravine North</option>
                <option value='10'>Whitemud Creek Ravine South</option>
                <option value='9'>Whitemud Creek Ravine Twin Brooks</option>
                <option value='9'>Windermere</option>
                <option value='9'>Windermere Area</option>
                <option value='9'>Keswick Area</option>
                <option value='9'>Glenridding Area</option>
                <option value='8'>Windsor Park</option>
                <option value='9'>Blackburne</option>
                <option value='9'>Haddow</option>
                <option value='9'>Hodgson</option>
                <option value='9'>Leger</option>
                <option value='9'>Terwillegar Towne</option>
                <option value='9'>South Terwillegar</option>
                <option value='11'>Argyll</option>
                <option value='11'>Avonmore</option>
                <option value='12'>Bisset</option>
                <option value='8'>Bonnie Doon</option>
                <option value='8'>Capilano</option>
                <option value='8'>Cloverdale</option>
                <option value='11'>Coronet Addition Industrial</option>
                <option value='11'>Coronet Industrial</option>
                <option value='11'>Cpr Irvine</option>
                <option value='12'>Crawford Plains</option>
                <option value='12'>Daly Grove</option>
                <option value='11'>Davies Industrial East</option>
                <option value='11'>Davies Industrial West</option>
                <option value='8'>Eastgate Business Park</option>
                <option value='11'>Edmonton Research And Development Park</option>
                <option value='11'>South Edmonton Common</option>
                <option value='11'>Ekota</option>
                <option value='12'>Ellerslie</option>
                <option value='12'>Summerside</option>
                <option value='12'>Ellerslie Industrial</option>
                <option value='12'>The Orchards At Ellerslie</option>
                <option value='8'>Forest Heights</option>
                <option value='8'>Fulton Place</option>
                <option value='11'>Gainer Industrial</option>
                <option value='11'>Girard Industrial</option>
                <option value='8'>Gold Bar</option>
                <option value='11'>Greenview</option>
                <option value='11'>Hazeldean</option>
                <option value='11'>Hillview</option>
                <option value='8'>Holyrood</option>
                <option value='8'>Idylwylde</option>
                <option value='12'>Jackson Heights</option>
                <option value='11'>Kameyosek</option>
                <option value='8'>Kenilworth</option>
                <option value='11'>King Edward Park</option>
                <option value='12'>Kiniski Gardens</option>
                <option value='8'>Lambton Industrial</option>
                <option value='12'>Larkspur</option>
                <option value='11'>Lee Ridge</option>
                <option value='11'>Maple Ridge</option>
                <option value='11'>Maple Ridge Industrial</option>
                <option value='11'>Mcintyre Industrial</option>
                <option value='12'>Meadows Area</option>
                <option value='12'>Maple</option>
                <option value='12'>Silver Berry</option>
                <option value='12'>Tamarack</option>
                <option value='12'>Laurel</option>
                <option value='11'>Menisa</option>
                <option value='11'>Meyokumin</option>
                <option value='11'>Meyonohk</option>
                <option value='11'>Michaels Park</option>
                <option value='8'>Mill Creek Ravine North</option>
                <option value='11'>Mill Creek Ravine South</option>
                <option value='11'>Mill Woods Golf Course</option>
                <option value='11'>Mill Woods Park</option>
                <option value='11'>Mill Woods Town Centre</option>
                <option value='12'>Minchau</option>
                <option value='11'>Morris Industrial</option>
                <option value='8'>Ottewell</option>
                <option value='11'>Papaschase Industrial</option>
                <option value='11'>Parsons Industrial</option>
                <option value='12'>Pollard Meadows</option>
                <option value='11'>Pylypow Industrial</option>
                <option value='11'>Richfield</option>
                <option value='11'>Ritchie</option>
                <option value='8'>River Valley Gold Bar</option>
                <option value='8'>River Valley Riverside</option>
                <option value='11'>Roper Industrial</option>
                <option value='11'>Rosedale Industrial</option>
                <option value='12'>Rural South East</option>
                <option value='12'>Charlesworth</option>
                <option value='12'>Walker</option>
                <option value='12'>Anthony Henday Southeast</option>
                <option value='11'>Sakaw</option>
                <option value='11'>Satoo</option>
                <option value='11'>Southeast Industrial</option>
                <option value='11'>Strathcona Industrial Park</option>
                <option value='8'>Strathearn</option>
                <option value='11'>Tawa</option>
                <option value='8'>Terrace Heights</option>
                <option value='11'>Tipaskan</option>
                <option value='11'>Tweddle Place</option>
                <option value='12'>Weinlos</option>
                <option value='11'>Weir Industrial</option>
                <option value='12'>Wild Rose</option>
            </select>
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

            select { width: 300px; }

        </style>
    </div>

    <div class="flex-justified" style="text-align: center;">
        <div class="column">
            <div class="whitecard" id="ward-display" style="display:none;">
                <h1>Your ward: <span id="your-ward"></span></h1>
            </div>
        </div>
    </div>

    <div class="flex-justified" style="text-align: center;">
        <div class="column">
            <div class="whitecard">
                <a href="http://daveberta.ca/edmonton-election/" class="button">View Candidates on Daveberta.ca</a>
            </div>
        </div>
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
@stop

@section('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>

        function displayWard(ward) {
            $('#your-ward').html(ward);
            $('#ward-display').show('fast');
        }

        $('#neighbourhood-select').select2({
            placeholder: "Select a Neighbourhood",
            allowClear: true
        });

        $('#neighbourhood-select').on("change", function (e) {
            displayWard($("#neighbourhood-select").val());
        });
    </script>
    <script src="https://d3js.org/d3.v3.min.js"></script>
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

            displayWard(ward);
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
@stop
