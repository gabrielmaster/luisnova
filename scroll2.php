<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>iScroll demo: Use transition</title>

<script type="text/javascript" src="js/iscroll.js"></script>

<script type="text/javascript">

        var myScroll;
        function loaded() {
                setTimeout(function () {
                        myScroll = new iScroll('standard');
                }, 100);
        }

        document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
        document.addEventListener('DOMContentLoaded', loaded, false);

</script>

<style type="text/css" media="all">


body {
	font-size:12px;
	-webkit-user-select:none;
    -webkit-text-size-adjust:none;
	font-family:helvetica;
	padding:20px;
}

#standard {
	position:relative; 
	width:300px; 
        height:200px;
	background:#aaa;
	overflow:auto;
	border:1px solid #aaa;
}

div.scroller { overflow: auto; width: 2000px; }


.scroller li {
	padding:0 10px;
	height:40px;
	line-height:40px;
	border-bottom:1px solid #ccc;
	border-top:1px solid #fff;
	background-color:#fafafa;
	font-size:14px;
        list-style:none;
        float: left;
}



</style>
</head>
<body>
    
    <div class="cualquiera">
        <h1>Open this page on iPad to test the difference</h1>
    </div>


<div id="standard">
	<div class="scroller">
		<ul>
			<li><strong>Standard iScroll</strong></li>
			<li>Pretty row 2</li>
			<li>Pretty row 3</li>
			<li>Pretty row 4</li>
			<li>Pretty row 5</li>
			<li>Pretty row 6</li>
			<li>Pretty row 7</li>
			<li>Pretty row 8</li>
			<li>Pretty row 9</li>
			<li>Pretty row 10</li>
			<li><strong>Standard iScroll</strong></li>
			<li>Pretty row 12</li>
			<li>Pretty row 13</li>
			<li>Pretty row 14</li>
			<li>Pretty row 15</li>
			<li>Pretty row 16</li>
			<li>Pretty row 17</li>
			<li>Pretty row 18</li>
			<li>Pretty row 19</li>
			<li>Pretty row 20</li>
			<li><strong>Standard iScroll</strong></li>
			<li>Pretty row 22</li>
			<li>Pretty row 23</li>
			<li>Pretty row 24</li>
			<li>Pretty row 25</li>
			<li>Pretty row 26</li>
			<li>Pretty row 27</li>
			<li>Pretty row 28</li>
			<li>Pretty row 29</li>
			<li>Pretty row 30</li>
			<li><strong>Standard iScroll</strong></li>
			<li>Pretty row 32</li>
			<li>Pretty row 33</li>
			<li>Pretty row 34</li>
			<li>Pretty row 35</li>
			<li>Pretty row 36</li>
			<li>Pretty row 37</li>
			<li>Pretty row 38</li>
			<li>Pretty row 39</li>
			<li>Pretty row 40</li>
		</ul>
	</div>
</div>

<div class="footer"><h2>El footer</h2></div>

</body>
</html>