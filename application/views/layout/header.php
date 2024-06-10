<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>SpotiFlex</title>
		<?=link_tag('assets/style2.css')?>
	</head>
	<body>
		
		<div>
    		<nav class="navigation">
        		<h1>SpotiFlex</h1>
        		<ul id="mainNav">
					<li class="buttonMain"><?=anchor("album",'Albums',['role'=>($choice=='album'?'button':'')])?></li>
					<li class="buttonMain"><?=anchor("artiste",'Artistes',['role'=>($choice=='artiste'?'button':'')])?></li>
					<li class="buttonMain"><?=anchor("playlist",'Playlists',['role'=>($choice=='playlist'?'button':'')])?></li>
    			</ul>
				<ul id="signNav">
					<li class="buttonMain"><?=anchor("playlist/create_users","Sign up")?></li>
					<li class="buttonMain"><?=anchor("playlist","Sign in")?></li>
    			</ul>
    		</nav>
		</div>
