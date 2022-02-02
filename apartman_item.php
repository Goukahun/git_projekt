<?php $i=0; while ($row_aktualis = mysqli_fetch_assoc($aktualis)) { $i++; ?>
<article id="objectIdx_<?=$i;?>" class="c-object">
    <?php /*
	<div class="c-object__tags">
        <div class="tag -lastMinute">-23%
        </div>
        <div class="tag">Kiemelt ajánlat
        </div>
    </div>
	*/ ?>
	<?php
	//lekérdezése
	$query_aktualis_kepek = "SELECT filename
							 FROM ingatlan_kepek
							 WHERE ingatlan_id = '".$row_aktualis['id']."'
						     ORDER BY sorszam";
	$aktualis_kepek = mysqli_query($conn, $query_aktualis_kepek) or die(mysqli_error($conn));
	//$row_aktualis_kepek = mysqli_fetch_assoc($aktualis_kepek);
	$totalRows_aktualis_kepek = mysqli_num_rows($aktualis_kepek);
	?>

	<?php if ($totalRows_aktualis_kepek>0) { ?>
	<div class="unslider" style="background: none;">
	  <div class="owl-carousel">
		<?php $i=0; while ($row_aktualis_kepek = mysqli_fetch_assoc($aktualis_kepek)) { $i++;
		$img = "images/ingatlan_kepek/".$row_aktualis['id']."/".$row_aktualis_kepek['filename'];
		?>
		<div>
		  <img src="/<?php echo $img; ?>" alt="<?php echo $row_aktualis['ingatlan_neve']; ?>" title="<?php echo $row_aktualis['ingatlan_neve']; ?>" data-imgid="<?php echo $i; ?>">
		</div>		
		 <?php } ?>
	  </div>
	</div>
	<?php } ?>


	<?php /*
    <div class="c-object__rating">
        <div class="c-userRating">
            <p class="c-userRating__label"> Értékelés
            </p>
            <span class="c-userRating__info">
	  <span class="c-userRating__info__count">1
	  </span>
            <span class="c-userRating__info__text">vélemény
	  </span>
            </span>
            <div class="c-userRating__hearts">
                <svg class="c-icon c-userRating__heart">
                    <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-heart" class="useCurrentColor">
                    </use>
                </svg>
                <svg class="c-icon c-userRating__heart">
                    <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-heart" class="useCurrentColor">
                    </use>
                </svg>
                <svg class="c-icon c-userRating__heart">
                    <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-heart" class="useCurrentColor">
                    </use>
                </svg>
                <svg class="c-icon c-userRating__heart">
                    <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-heart" class="useCurrentColor">
                    </use>
                </svg>
                <svg class="c-icon c-userRating__heart">
                    <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-heart" class="useCurrentColor">
                    </use>
                </svg>
            </div>
            <strong aria-label="Customers rated these holiday homes with 5.00 out of 5 points." class="c-userRating__grade"></strong>
        </div>
    </div>
	*/ ?>
    <header class="c-object__header">
        <div class="c-object__badgeList">
            <figure role="group" class="c-object__badge">
                <img src="/szallashelyek/apartmanok_files/USP_Local.svg" data-label="" alt="" title="" class="c-object__badge__image">
            </figure>
        </div>
		<?php		
		$str_tavolsag = "";
		
		//jellemzo
		$query_aktualis_jellemzo = "SELECT id, nev
									FROM jellemzo
								  	WHERE 
								  	kategoria_id = '2'
								    ";
		$aktualis_jellemzo = mysqli_query($conn, $query_aktualis_jellemzo) or die(mysqli_error());
		//$row_aktualis_jellemzo = mysqli_fetch_assoc($aktualis_jellemzo);
		$totalRows_aktualis_jellemzo = mysqli_num_rows($aktualis_jellemzo);
		
		while ($row_aktualis_jellemzo = mysqli_fetch_assoc($aktualis_jellemzo)) {
			
			//jellemzo
			$query_aktualis_jellemzo_kapcs = "SELECT id
											  FROM ingatlan_jellemzo_kapcs
								  	          WHERE 
								  	          ingatlan_id = '".$row_aktualis['id']."' and jellemzo_kategoria_id = '2' and jellemzo_id = '".$row_aktualis_jellemzo['id']."'
								       ";
			$aktualis_jellemzo_kapcs = mysqli_query($conn, $query_aktualis_jellemzo_kapcs) or die(mysqli_error());
			$row_aktualis_jellemzo_kapcs = mysqli_fetch_assoc($aktualis_jellemzo_kapcs);
			$totalRows_aktualis_jellemzo_kapcs = mysqli_num_rows($aktualis_jellemzo_kapcs);
		
			if ($totalRows_aktualis_jellemzo_kapcs==1) $str_tavolsag = $row_aktualis_jellemzo['nev'];
			
			
		}
		?>
        <section class="c-breadcrumb">
            <ol class="c-breadcrumb__list c-object__breadcrumb">
                <li class="c-breadcrumb__item">
                    <a href="#" title="Spain" class="c-breadcrumb__link">Balaton</a>
                </li>
                <li class="c-breadcrumb__item">
                    <a href="#" title="<?php echo $row_aktualis['varos']; ?>" class="c-breadcrumb__link"><?php echo $row_aktualis['varos']; ?></a>
                </li>
                <li class="c-breadcrumb__item">
                    <a href="#" title="<?php echo $str_tavolsag; ?>" class="c-breadcrumb__link"><?php echo $str_tavolsag; ?></a>
                </li>
                <li class="c-breadcrumb__item">
                    <a title="<?php echo $row_aktualis['szelesseg'].", ".$row_aktualis['hosszusag']; ?>" href="/apartman" class="c-breadcrumb__link c-breadcrumb__link--current"><?php echo $row_aktualis['szelesseg'].", ".$row_aktualis['hosszusag']; ?></a>
                </li>
            </ol>
        </section>
		<h3>Nyaraló azonosító: <?php echo $row_aktualis['referenciaszam']; ?></h3>
        <h2 class="c-object__title">
	<?php /*
	<span class="c-object__stars">
	  <svg class="c-icon c-object__star">
		<use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-star" class="useCurrentColor">
		</use>
	  </svg> 
	  <svg class="c-icon c-object__star">
		<use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-star" class="useCurrentColor">
		</use>
	  </svg> 
	  <svg class="c-icon c-object__star">
		<use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-star" class="useCurrentColor">
		</use>
	  </svg>
	</span> 
	*/ ?>
	<a href="/apartman" class="c-object__link"><?php echo $row_aktualis['ingatlan_neve']; ?></a></h2>
    </header>
    <div class="c-object__featureList">
        <div class="c-object__feature c-featureImage">
            <svg class="c-featureImage__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-user">
                </use>
            </svg>
            <p class="c-featureImage__label"> <?php echo $row_aktualis['ar_osszes_ferohely']; ?> fő részére
            </p>
        </div>
        <div class="c-object__feature c-featureImage">
            <svg class="c-featureImage__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-door">
                </use>
            </svg>
            <p class="c-featureImage__label"> <?php echo $row_aktualis['szobak_szama']; ?> szoba
            </p>
        </div>
        <div class="c-object__feature c-featureImage">
            <svg class="c-featureImage__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-bed">
                </use>
            </svg>
            <p class="c-featureImage__label"> <?php echo $row_aktualis['haloszobak_szama']; ?> hálószoba
            </p>
        </div>
        <div class="c-object__feature c-featureImage">
            <svg class="c-featureImage__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-towel">
                </use>
            </svg>
            <p class="c-featureImage__label"> <?php echo $row_aktualis['furdoszobak_szama']; ?> fürdőszoba
            </p>
        </div>
    </div>
    <div class="c-object__featureList -secondary">
        <button class="c-object__expandFeatures" style="display: none;">
            <span class="c-object__expandFeatures__idle">Tovább
	</span>
            <span class="c-object__expandFeatures__expanded">Show less
	</span>
            <img src="/szallashelyek/apartmanok_files/down-arrow-676767.svg" alt="" class="c-icon">
        </button>
		
		<?php		
		$str_kilatas = "";
		
		//jellemzo
		$query_aktualis_jellemzo = "SELECT id, nev
									FROM jellemzo
								  	WHERE 
								  	kategoria_id = '10'
								    ";
		$aktualis_jellemzo = mysqli_query($conn, $query_aktualis_jellemzo) or die(mysqli_error());
		//$row_aktualis_jellemzo = mysqli_fetch_assoc($aktualis_jellemzo);
		$totalRows_aktualis_jellemzo = mysqli_num_rows($aktualis_jellemzo);
		
		while ($row_aktualis_jellemzo = mysqli_fetch_assoc($aktualis_jellemzo)) {
			
			//jellemzo
			$query_aktualis_jellemzo_kapcs = "SELECT id
											  FROM ingatlan_jellemzo_kapcs
								  	          WHERE 
								  	          ingatlan_id = '".$row_aktualis['id']."' and jellemzo_kategoria_id = '10' and jellemzo_id = '".$row_aktualis_jellemzo['id']."'
								       ";
			$aktualis_jellemzo_kapcs = mysqli_query($conn, $query_aktualis_jellemzo_kapcs) or die(mysqli_error());
			$row_aktualis_jellemzo_kapcs = mysqli_fetch_assoc($aktualis_jellemzo_kapcs);
			$totalRows_aktualis_jellemzo_kapcs = mysqli_num_rows($aktualis_jellemzo_kapcs);
		
			if ($totalRows_aktualis_jellemzo_kapcs==1) $str_kilatas = $row_aktualis_jellemzo['nev'];
			
			
		}
		?>
		<?php if (strlen($str_kilatas)>0) { ?>
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-view">
                </use>
            </svg>
            <p class="c-featureImage__label"> <?php echo $str_kilatas; ?>
            </p>
        </div>
		<?php } ?>
		
		<?php if (strlen($str_tavolsag)>0) { ?>
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-strand">
                </use>
            </svg>
            <p class="c-featureImage__label"> <?php echo $str_tavolsag; ?>
            </p>
        </div>
		<?php } ?>
		
		<?php
			$str_internet = "";
			
			//jellemzo
			$query_aktualis_jellemzo_kapcs = "SELECT id
											  FROM ingatlan_jellemzo_kapcs
								  	          WHERE 
								  	          ingatlan_id = '".$row_aktualis['id']."' and jellemzo_kategoria_id = '1' and jellemzo_id = '2'
								       ";
			$aktualis_jellemzo_kapcs = mysqli_query($conn, $query_aktualis_jellemzo_kapcs) or die(mysqli_error());
			$row_aktualis_jellemzo_kapcs = mysqli_fetch_assoc($aktualis_jellemzo_kapcs);
			$totalRows_aktualis_jellemzo_kapcs = mysqli_num_rows($aktualis_jellemzo_kapcs);
		
			if ($totalRows_aktualis_jellemzo_kapcs==1) $str_internet = "VAN";
		?>
		<?php if (strlen($str_internet)>0) { ?>
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-wifi">
                </use>
            </svg>
            <p class="c-featureImage__label"> WiFi
            </p>
        </div>
		<?php } ?>
		
		<?php
			$str_mosogep = "";
			
			//jellemzo
			$query_aktualis_jellemzo_kapcs = "SELECT id
											  FROM ingatlan_jellemzo_kapcs
								  	          WHERE 
								  	          ingatlan_id = '".$row_aktualis['id']."' and jellemzo_kategoria_id = '1' and jellemzo_id = '29'
								       ";
			$aktualis_jellemzo_kapcs = mysqli_query($conn, $query_aktualis_jellemzo_kapcs) or die(mysqli_error());
			$row_aktualis_jellemzo_kapcs = mysqli_fetch_assoc($aktualis_jellemzo_kapcs);
			$totalRows_aktualis_jellemzo_kapcs = mysqli_num_rows($aktualis_jellemzo_kapcs);
		
			if ($totalRows_aktualis_jellemzo_kapcs==1) $str_mosogep = "VAN";
		?>
		<?php if (strlen($str_mosogep)>0) { ?>
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-waschmaschine">
                </use>
            </svg>
            <p class="c-featureImage__label"> Mosógép
            </p>
        </div>
		<?php } ?>
		
		<?php /*
		<?php		
		$str_szorakoztatas = "";
		
		//jellemzo
		$query_aktualis_jellemzo = "SELECT id, nev
									FROM jellemzo
								  	WHERE 
								  	kategoria_id = '8'
								    ";
		$aktualis_jellemzo = mysqli_query($conn, $query_aktualis_jellemzo) or die(mysqli_error());
		//$row_aktualis_jellemzo = mysqli_fetch_assoc($aktualis_jellemzo);
		$totalRows_aktualis_jellemzo = mysqli_num_rows($aktualis_jellemzo);
		
		while ($row_aktualis_jellemzo = mysqli_fetch_assoc($aktualis_jellemzo)) {
			
			//jellemzo
			$query_aktualis_jellemzo_kapcs = "SELECT id
											  FROM ingatlan_jellemzo_kapcs
								  	          WHERE 
								  	          ingatlan_id = '".$row_aktualis['id']."' and jellemzo_kategoria_id = '8' and jellemzo_id = '".$row_aktualis_jellemzo['id']."'
								       ";
			$aktualis_jellemzo_kapcs = mysqli_query($conn, $query_aktualis_jellemzo_kapcs) or die(mysqli_error());
			$row_aktualis_jellemzo_kapcs = mysqli_fetch_assoc($aktualis_jellemzo_kapcs);
			$totalRows_aktualis_jellemzo_kapcs = mysqli_num_rows($aktualis_jellemzo_kapcs);
		
			if ($totalRows_aktualis_jellemzo_kapcs==1) $str_szorakoztatas = $row_aktualis_jellemzo['nev'];			
			
		}
		?>
		<?php if (strlen($str_szorakoztatas)>0) { ?>
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-tv">
                </use>
            </svg>
            <p class="c-featureImage__label"> <?php echo $str_szorakoztatas; ?>
            </p>
        </div>
		<?php } ?>
		*/ ?>
		
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-klima">
                </use>
            </svg>
            <p class="c-featureImage__label"> ??? Légkondícionáló ??? 
            </p>
        </div>

		<?php if ($row_aktualis['kutyabarat'] == 1) { ?>
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-tv">
                </use>
            </svg>
            <p class="c-featureImage__label"> Kutyabarát
            </p>
        </div>
		<?php } ?>
		
		<div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-klima">
                </use>
            </svg>
            <p class="c-featureImage__label"> ??? Bababarát ???
            </p>
        </div>
		
		<?php
			$str_wellness = "";
			
			//jellemzo
			$query_aktualis_jellemzo_kapcs = "SELECT id
											  FROM ingatlan_jellemzo_kapcs
								  	          WHERE 
								  	          ingatlan_id = '".$row_aktualis['id']."' and jellemzo_kategoria_id = '7' and jellemzo_id = '117'
								       ";
			$aktualis_jellemzo_kapcs = mysqli_query($conn, $query_aktualis_jellemzo_kapcs) or die(mysqli_error());
			$row_aktualis_jellemzo_kapcs = mysqli_fetch_assoc($aktualis_jellemzo_kapcs);
			$totalRows_aktualis_jellemzo_kapcs = mysqli_num_rows($aktualis_jellemzo_kapcs);
		
			if ($totalRows_aktualis_jellemzo_kapcs==1) $str_wellness = "VAN";
		?>
		<?php if (strlen($str_wellness)>0) { ?>
        <div class="c-object__feature c-featureImage">
            <svg class="c-object__attribute__icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#attr-tv">
                </use>
            </svg>
            <p class="c-featureImage__label"> Wellness
            </p>
        </div>
		<?php } ?>
		
    </div>
	<?php /*
	<div>
		<?php echo $row_aktualis['rovid_leiras_hun']; ?>
	</div>	
	*/ ?>
    <div class="c-object__price">        
		<?php
		//arak_kapcs
		$query_aktualis_arak_kapcs = "SELECT *
								 	   FROM arak_kapcs
								  	   WHERE 
								  	   ingatlan_id = '".$row_aktualis['id']."' AND
									   (datum_ig >= '".date("Y-m-d")."' AND datum_tol <= '".date("Y-m-d H:i:s")."')
								       ";
		//echo $query_aktualis_arak_kapcs;
		$aktualis_arak_kapcs = mysqli_query($conn, $query_aktualis_arak_kapcs) or die(mysqli_error());
		$row_aktualis_arak_kapcs = mysqli_fetch_assoc($aktualis_arak_kapcs);
		$totalRows_aktualis_arak_kapcs = mysqli_num_rows($aktualis_arak_kapcs);
		?>
		<?php if ($totalRows_aktualis_arak_kapcs > 0) { ?>
		<p class="c-object__price__settings">
		bérelhető <?php echo $row_aktualis_arak_kapcs['min_ejszaka']; ?> éjszakától
		</p>
		<p class="c-object__price__value">
			<strong class="c-object__price__content">
			<?php
			$ar_nem = "Ft";
			if ($row_aktualis_arak_kapcs['tulajdonos_ar_nem']==2) $ar_nem = "Euro";
			$jutalek = ($row_aktualis_arak_kapcs['tulajdonos_ar']/100)*($row_aktualis_arak_kapcs['jutalek']-100);
			$ar = number_format($row_aktualis_arak_kapcs['tulajdonos_ar']+$jutalek, 0, '', '.')." ".$ar_nem." / éjszaka";
			echo $ar;
			?>
			</strong>
		</p>		
        <p class="c-object__price__info c-tooltip -bottom">további költségek merülhetnek fel
            <svg viewBox="0 0 576.5 576.5" class="c-icon c-tooltip__icon">
                <title>info
                </title>
                <path d="M288.3 0C129.1 0 0 129.1 0 288.3s129.1 288.3 288.3 288.3 288.3-129.1 288.3-288.3S447.5 0 288.3 0zm25.9 441.5H252V216h62.2v225.5zm0-259.4H252v-55.9h62.2v55.9z">
                </path>
            </svg>
            <span class="c-tooltip__content">plusz kötelező vagy választható díjak a tényleges kihasználtság vagy tényleges fogyasztás alapján</span>
        </p>
		<?php } ?>
    </div>
    <div class="c-object__actions">
		<?php /*
        <button id="notePadAction_0" data-src-id="objectIdx_1" data-id="np_ES9730_342_1" class="c-object__action -save">
            <svg class="c-icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-smileFavourites">
                </use>
            </svg>
            <span>Kedvencekhez ad
			</span>
        </button>
		*/ ?>
		<?php if ($row_aktualis['part'] > 0) { ?>
		<span><?php echo ($row_aktualis['part'] == 1) ? "Balaton északi part" : "Balaton déli part"; ?></span>
		<?php } ?>
        <button data-viewstatus="closed" data-id="map_ES9730_342_1" class="c-object__map__switch c-object__action -map c-object__action -map">
            <svg class="c-icon">
                <use xlink:href="/szallashelyek/apartmanok_files/sprite.svg#icon-placeholder">
                </use>
            </svg> Térkép
        </button>
    </div>
    <button  data-src-id="objectIdx__<?=$i;?>"type="button" onclick="location.href='/apartmanok/apartman?id=<?php echo $row_aktualis['id']; ?>';" class="c-object__action -discover waves-effect"> Megnézem
    </button>
    <div style="display: none;" class="c-object__map">
        <!---->
        <div class="object-card object-card--appear">
            <div class="object-card__image">
                <!---->
                <div class="object-card__label">
                </div>
            </div>
            <div class="object-card__body-wrap">
                <div class="object-card__body-slider">
                    <div class="object-card__body">
                        <p class="object-card__summary">
                            <!---->
                            <!---->
                        </p>
                        <!---->
                        <!---->
                    </div>
                </div>
            </div>
            <footer class="object-card__footer">
                <!---->
                <a target="_blank" class="btn btn--ghost">More Info</a>
                <!---->
            </footer>
            <button class="object-card__close">
            </button>
        </div>
    </div>
</article>
<?php } ?>