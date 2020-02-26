<!DOCTYPE html>
<html>
<head>
	<title>&lt;?='hello-world' ?&gt;</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
	<style>
	body {
		background-color: #1d1e21;
		color: #666;
		text-align: center;
		font-family: "Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
	}

	[tag] {
		margin-bottom: 40px;
		font-size: 5em;
		font-family: monospace;
	}

	a {
		color: inherit;
	}

	/* center */
	html {
		display: flex;
        flex-flow: row nowrap;  
        justify-content: center;
        align-content: center;
        align-items: center;
        height: 100%;
        margin: 0;
        padding: 0;
	}
	body {
		flex: 0 1 auto;
        align-self: auto;
	}
	</style>
</head>
<body>
	<main>
		<div tag>
			<font color="white">&lt;?=</font>'<font color="deeppink">hello</font><font color="limegreen">-<?=(!empty($_ENV["NAME"])?$_ENV["NAME"]:"world")?></font>'&nbsp;<font color="white">?&gt;</font>
		</div>
		<?php if(!empty($_ENV["HOSTNAME"])) {?><h3>My hostname is <?php echo $_ENV["HOSTNAME"]; ?></h3><?php } ?>
		<?php
		$links = [];
		foreach($_ENV as $key => $value) {
			if(preg_match("/^(.*)_PORT_([0-9]*)_(TCP|UDP)$/", $key, $matches)) {
				$links[] = [
					"name" => $matches[1],
					"port" => $matches[2],
					"proto" => $matches[3],
					"value" => $value
				];
			}
		}
		if($links) {
		?>
			<h3>Links found</h3>
			<?php
			foreach($links as $link) {
				?>
				<b><?php echo $link["name"]; ?></b> listening in <?php echo $link["port"] . "/" . $link["proto"]; ?> available at <?php echo $link["value"]; ?><br />
				<?php
			}
			?>
		<?php
		}
		?>
		<a href="info.php">PHP <?=sprintf('%d.%d.%d', PHP_MAJOR_VERSION, PHP_MINOR_VERSION, PHP_RELEASE_VERSION)?> info</a> &mdash; <a href="https://github.com/BananaAcid/docker-php7.4-kitematic#readme" target="_blank">readme on github</a> &mdash; <a href="getcert.php">localhost certificate</a>
	</main>
</body>
</html>
