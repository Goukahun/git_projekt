<?php
require_once('connections/conn.php');	

//lekérdezése
$maxRows_aktualis = 10;
if (strlen($_REQUEST['page']) == 0) $_REQUEST['page'] = 0;
$startRow_aktualis = $_REQUEST['page'] * $maxRows_aktualis;

$query_aktualis = "SELECT ingatlan.* 
				   FROM ingatlan";

if ( 
	$_REQUEST['luxus']==1 or 
	strlen($_REQUEST['kilatas_a_balatonra']) > 0 or 
	$_REQUEST['sajat_strand']==1 or 
	$_REQUEST['steg']==1 or 
	$_REQUEST['mosogep']==1 or
	$_REQUEST['legkondicionalas']==1 or
	$_REQUEST['futes']==1 or
	$_REQUEST['erkely_terasz'] == 1
	) 
	$query_aktualis .= " INNER JOIN ingatlan_jellemzo_kapcs ON ingatlan.id = ingatlan_jellemzo_kapcs.ingatlan_id";
				   
$query_aktualis .= " WHERE ingatlan.kozzeteve = 1";

if ($_REQUEST['k'] == 1) {
	
	// Általános információ
	
	if ($_REQUEST['kategoria_id']>0) $query_aktualis .= " AND ingatlan.kategoria_id = '".mysqli_real_escape_string($conn, $_REQUEST['kategoria_id'])."'";
	
	// Általános információ
	
	// Elhelyezkedés
	
	if (strlen($_REQUEST['referenciaszam'])>0) $query_aktualis .= " AND ingatlan.referenciaszam = '".mysqli_real_escape_string($conn, $_REQUEST['referenciaszam'])."'";
	
	if ($_REQUEST['part']>0) $query_aktualis .= " AND ingatlan.part = '".mysqli_real_escape_string($conn, $_REQUEST['part'])."'";
	
	if ($_REQUEST['megye_id']>0) $query_aktualis .= " AND ingatlan.megye_id = '".mysqli_real_escape_string($conn, $_REQUEST['megye_id'])."'";
	
	if (strlen($_REQUEST['varos'])>0) $query_aktualis .= " AND ingatlan.varos = '".mysqli_real_escape_string($conn, $_REQUEST['varos'])."'";
	
	// Elhelyezkedés
	
	// Más információ
	
	if ($_REQUEST['ar_osszes_ferohely']>0) $query_aktualis .= " AND ingatlan.ar_osszes_ferohely = '".mysqli_real_escape_string($conn, $_REQUEST['ar_osszes_ferohely'])."'";
	
	if ($_REQUEST['gyerek_szama_max']>0) $query_aktualis .= " AND ingatlan.gyerek_szama_max = '".mysqli_real_escape_string($conn, $_REQUEST['gyerek_szama_max'])."'";
		
	if ($_REQUEST['haloszobak_szama']>0) $query_aktualis .= " AND ingatlan.haloszobak_szama = '".mysqli_real_escape_string($conn, $_REQUEST['haloszobak_szama'])."'";
	
	if ($_REQUEST['szobak_szama']>0) $query_aktualis .= " AND ingatlan.szobak_szama = '".mysqli_real_escape_string($conn, $_REQUEST['szobak_szama'])."'";
	
	//if ($_REQUEST['furdoszobak_szama']>0) $query_aktualis .= " AND ingatlan.furdoszobak_szama = '".mysqli_real_escape_string($conn, $_REQUEST['furdoszobak_szama'])."'";
	
	// Más információ
	
	/*
	if ($_REQUEST['medence']>0) {
		
		$t_medence = explode("_", $_REQUEST['medence']);
		
		$jellemzo_kategoria_id = $t_medence[0];
		$jellemzo_id = $t_medence[1];
		
		$query_aktualis .= " AND ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '".$jellemzo_kategoria_id."' AND ingatlan_jellemzo_kapcs.jellemzo_id = '".$jellemzo_id."'";
		
	}
	*/
	
	// Általános információk / Felszereltség
	$sql_kereso_1 = "";
	
	if (
		$_REQUEST['luxus'] == 1 or
		strlen($_REQUEST['kilatas_a_balatonra']) > 0 or
		$_REQUEST['kutyabarat'] == 1 or
		$_REQUEST['sajat_strand'] == 1 or
		$_REQUEST['last_minute'] == 1 or
		strlen($_REQUEST['steg']) > 0 or
		$_REQUEST['mosogep'] == 1 or
		$_REQUEST['legkondicionalas']==1 or
		$_REQUEST['futes']==1 or
		$_REQUEST['erkely_terasz'] == 1
	) {
		$sql_kereso_1 = " AND ( ";
	}
	
	if ($_REQUEST['luxus']==1) $sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '1' AND ingatlan_jellemzo_kapcs.jellemzo_id = '20') OR ";
	
	if (strlen($_REQUEST['kilatas_a_balatonra']) > 0) {
		
		$t_kilatas_a_balatonra = explode("_", $_REQUEST['kilatas_a_balatonra']);
		
		$jellemzo_kategoria_id = $t_kilatas_a_balatonra[0];
		$jellemzo_id = $t_kilatas_a_balatonra[1];
		
		$sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '".$jellemzo_kategoria_id."' AND ingatlan_jellemzo_kapcs.jellemzo_id = '".$jellemzo_id."') OR ";
		
	}
	
	if ($_REQUEST['kutyabarat']==1) $sql_kereso_1 .= "(ingatlan.kutyabarat = '".mysqli_real_escape_string($conn, $_REQUEST['kutyabarat'])."') OR ";
	
	if ($_REQUEST['sajat_strand']==1) $sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '1' AND ingatlan_jellemzo_kapcs.jellemzo_id = '25') OR ";
	
	if ($_REQUEST['last_minute']==1) $sql_kereso_1 .= "(ingatlan.last_minute = '".mysqli_real_escape_string($conn, $_REQUEST['last_minute'])."') OR ";
		
	if (strlen($_REQUEST['steg']) > 0) {
		
		$t_steg = explode("_", $_REQUEST['steg']);
		
		$jellemzo_kategoria_id = $t_steg[0];
		$jellemzo_id = $t_steg[1];
		
		$sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '".$jellemzo_kategoria_id."' AND ingatlan_jellemzo_kapcs.jellemzo_id = '".$jellemzo_id."') OR ";
		
	}
	
	if ($_REQUEST['mosogep']==1) $sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '1' AND ingatlan_jellemzo_kapcs.jellemzo_id = '29') OR ";
	
	if ($_REQUEST['erkely_terasz']==1) $sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '1' AND ingatlan_jellemzo_kapcs.jellemzo_id = '128') OR ";
	
	if ($_REQUEST['legkondicionalas']==1) $sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '1' AND ingatlan_jellemzo_kapcs.jellemzo_id = '129') OR ";
	
	if ($_REQUEST['futes']==1) $sql_kereso_1 .= "(ingatlan_jellemzo_kapcs.jellemzo_kategoria_id = '1' AND ingatlan_jellemzo_kapcs.jellemzo_id = '130') OR ";
	
	if (strlen($sql_kereso_1) > 0) {
		
		$sql_kereso_1 = substr($sql_kereso_1, 0, -4);
		
	}
	
	if (
		$_REQUEST['luxus'] == 1 or
		strlen($_REQUEST['kilatas_a_balatonra']) > 0 or
		$_REQUEST['kutyabarat'] == 1 or
		$_REQUEST['sajat_strand'] == 1 or
		$_REQUEST['last_minute'] == 1 or
		strlen($_REQUEST['steg']) > 0 or
		$_REQUEST['mosogep'] == 1 or
		$_REQUEST['legkondicionalas']==1 or
		$_REQUEST['futes']==1 or
		$_REQUEST['erkely_terasz'] == 1
	) {
		$sql_kereso_1 .= " ) ";
	}
	
	//echo $sql_kereso_1."<br>";
	
	$query_aktualis .= $sql_kereso_1;
	
	// Általános információk / Felszereltség
	
}

$query_aktualis .= " GROUP BY ingatlan.id";

switch ($_REQUEST['rendezes']) {
	case 2 : $query_aktualis .= " ORDER BY ingatlan.referenciaszam DESC"; break;
	default : {
		$_REQUEST['rendezes'] = 1;
		$query_aktualis .= " ORDER BY ingatlan.referenciaszam";
	}
}

echo $query_aktualis;

$query_limit_aktualis = sprintf("%s LIMIT %d, %d", $query_aktualis, $startRow_aktualis, $maxRows_aktualis);
$aktualis = mysqli_query($conn, $query_limit_aktualis) or die(mysqli_error($conn));
//$row_aktualis = mysqli_fetch_assoc($aktualis);


if (isset($_REQUEST['totalRows_aktualis'])) $totalRows_aktualis = $_REQUEST['totalRows_aktualis'];
else {
	$all_aktualis = mysqli_query($conn, $query_aktualis);
	$totalRows_aktualis = mysqli_num_rows($all_aktualis);
}
$totalPages_aktualis = ceil($totalRows_aktualis/$maxRows_aktualis)-1;

//lekérdezése
$query_aktualis_inagtlan_kategoria = "SELECT *
									  FROM ingatlan_kategoria
									  ORDER BY nev";
$aktualis_inagtlan_kategoria = mysqli_query($conn, $query_aktualis_inagtlan_kategoria) or die(mysqli_error($conn));
//$row_aktualis_inagtlan_kategoria = mysqli_fetch_assoc($aktualis_inagtlan_kategoria);
$totalRows_aktualis_inagtlan_kategoria = mysqli_num_rows($aktualis_inagtlan_kategoria);

//lekérdezése
$query_aktualis_megyek = "SELECT DISTINCT(megyek.id), megyek.megye
						  FROM megyek
						  INNER JOIN ingatlan ON ingatlan.megye_id=megyek.id
						  ORDER BY megyek.megye";
$aktualis_megyek = mysqli_query($conn, $query_aktualis_megyek) or die(mysqli_error());
//$row_aktualis_megyek = mysqli_fetch_assoc($aktualis_megyek);
$totalRows_aktualis_megyek = mysqli_num_rows($aktualis_megyek);

//lekérdezése
$query_aktualis_varos = "SELECT DISTINCT(varos) FROM ingatlan WHERE varos != ''";
$aktualis_varos = mysqli_query($conn, $query_aktualis_varos) or die(mysqli_error());
//$row_aktualis_varos = mysqli_fetch_assoc($aktualis_varos);
$totalRows_aktualis_varos = mysqli_num_rows($aktualis_varos);
?>		
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>			 					 				
<link rel="stylesheet" href="/szallashelyek/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="/szallashelyek/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
<script type="text/javascript" src="/szallashelyek/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>        
<link rel="stylesheet" media="screen" href="/szallashelyek/apartmanok_files/ih-styles.css">				 				
<link rel="stylesheet" media="print" href="/szallashelyek/apartmanok_files/ih-print.css">				
<link rel="stylesheet" href="/szallashelyek/apartmanok_files/sprite.css">
<style>
.unslider-arrow {
	position: absolute;
}
#pets input {
	position: relative;
}
#sp-bottom img {
    width: inherit;
    height: auto;
    border: none;
    max-width: 100%;
}
.c-hitlist__searchrefinement__applyFilter {
    position: relative;
    bottom: 0;
    margin-bottom: 1.2em;
    z-index: 100;
}
#sp-bottom ul.social-icons li {
    display: inline-block;
    margin: 5px 7px;
	padding: 0;
}
#sp-bottom h3 {
    color: #fff;
}
#sp-bottom .sp-column, .sp-copyright {
    font-family: Poppins, sans-serif;
    font-size: 14px;
    font-weight: 300;
}
#sp-bottom p {
    margin: 0 0 10px;
}
#sp-bottom ul.social-icons {
    list-style: none;
    padding: 0;
    margin: -5px;
    display: inline-block;
}
.sp-megamenu-wrapper ul li a:hover {
    text-decoration: none;
}
</style>
<script>
function page(i) {
	
	$("#form").attr("onsubmit","");
	
	$('#page').val(i);
	$('#form').submit();
}
</script>
<form name="form" id="form" action="/apartmanok" onSubmit="$('#page').val(0); <?php /*$('#rendezes').val(1);*/ ?>" method="get">
<input type="hidden" id="k" name="k" value="0"> 
      <section id="vue-searchresults" class="c-hitlist"> 
       
        <div id="hitlist" class="c-hitlist__hitlist">
          <div class="c-hitlist__opt">
            <!-- TÓDI <nav class="c-hitlist__switch">
              <a class="btn c-hitlist__switch__item c-hitlist__switch__item--list c-hitlist__switch__item--is-active">List</a> 
              <a class="btn c-hitlist__switch__item c-hitlist__switch__item--map">Map</a>
            </nav>--> 
            <span class="c-hitlist__opt__title" style="display: flex; justify-content: flex-end; align-items: center; font-size: 1rem; height: 4rem;"><?php echo $totalRows_aktualis; ?> Találat
            </span> 
            <div class="c-hitlist__opt__sort">
              <select id="result_sorting" name="result_sorting" data-tracked="true">
                <option value="descszallashelyek/apartmanok_files" selected="selected">Listázási nézet
                </option> 
                <option value="descLastBookDay">Népszerű
                </option> 
                <option value="ascAge">Legújabbak
                </option> 
                <option value="descAverageRating">Vélemények alapján
                </option> 
                <option value="ascPrice">Ár (alacsony...magas)
                </option> 
                <option value="descPrice">Ár (magas...alacsony)
                </option> 
                <option value="ascPerson">Személyek száma (emelkedő)
                </option> 
                <option value="descPerson">Személyek száma (csökkenő)
                </option>
              </select>
            </div>
          </div> 

          <div class="hitlist-wrapper">
			
            <div class="c-objectList">
			  
			<input type="hidden" name="page" id="page" value="<?php echo $_REQUEST['page']; ?>">
              <?php	require_once('apartman_item.php'); ?>
			  
			  <?php include('inc_lapozo.php'); ?>
			
            </div>
			
          </div> 
		  
          <div class="map-wrapper" style="display: none;">
            <div style="display: none;" class="c-hitlist__map googlemap__wrapper googlemap__wrapper--large">
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
                  <a target="_blank" class="btn btn--ghost">Megnézem</a>
                  <!---->
                </footer>
                <button class="object-card__close">
                </button>
              </div>
            </div>
          </div> 
        </div> 
        <div id="overlay" class="c-hitlist__searchrefinement overlay2">
          <div class="c-hitlist__searchrefinement__inner overlay__inner">
            <div class="overlay__header">
              <div class="overlay__header__close__wrapper">
                <img id="overlayClose" src="/szallashelyek/apartmanok_files/close-ffffff.svg" alt="" class="overlay__header__close">
              </div> 
              <div class="overlay__header__title__wrapper">
                <p class="overlay__header__title">részletes keresés
                </p>
              </div> 
              <div class="overlay__header__action__wrapper">
                <p id="overlayReset" class="overlay__header__action">revert
                </p>
              </div>
            </div> 
            <div class="overlay__footer">
              <button id="filterSearchButton" type="button" class="c-hitlist__topbar__searchSubmit btn btn--search waves-effect">keresés
              </button>
            </div> 
      
              <span class="c-hitlist__searchrefinement__title c-hitlist__searchrefinement__title--filter icon">részletes keresés
              </span>   
			  
			  <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span>
				<h3>Általános információ</h3>				
                <p data-label="kategoria" class="c-hitlist__label">Karegória</p> 
                <div id="kategoria" class="stepper__wrapper">
					<select name="kategoria_id" id="kategoria_id" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['kategoria_id']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<option value="1" <?php if ($_REQUEST['kategoria_id']==1) echo 'selected="selected"'; ?>>Nyaralóház</option> 
						<option value="4" <?php if ($_REQUEST['kategoria_id']==4) echo 'selected="selected"'; ?>>Apartman</option> 
					</select>
                </div>                 
              </div> 
			  
			  <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span>
				<h3>Elhelyezkedés</h3>
                <p class="c-hitlist__label">Nyaraló azonosító</p> 
                <div class="stepper__wrapper">
					<input type="text" name="referenciaszam" id="referenciaszam" value="<?php echo $_REQUEST['referenciaszam']; ?>">
                </div>
				<p class="c-hitlist__label">Balaton régió</p> 
                <div class="stepper__wrapper">
					<select name="part" id="part" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['part']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<option value="1" <?php if ($_REQUEST['part']==1) echo 'selected="selected"'; ?>>Balaton északi part</option> 
						<option value="2" <?php if ($_REQUEST['part']==2) echo 'selected="selected"'; ?>>Balaton déli part</option> 
					</select>
                </div>
				<p class="c-hitlist__label">Megye</p> 
                <div class="stepper__wrapper">
					<select name="megye_id" id="megye_id" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['megye_id']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<?php while ($row_aktualis_megyek = mysqli_fetch_assoc($aktualis_megyek)) { ?>
						<option value="<?php echo $row_aktualis_megyek['id']; ?>" <?php if ($row_aktualis_megyek['id']==$_POST['megye_id']) echo "selected"; ?>><?php echo $row_aktualis_megyek['megye']; ?></option> 
						<?php } ?>
					</select>
                </div>
				<p class="c-hitlist__label">Város</p> 
                <div class="stepper__wrapper">
					<select name="varos" id="varos" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="" <?php if ($_REQUEST['varos']=="") echo 'selected="selected"'; ?>>Válasszon</option> 
						<?php while ($row_aktualis_varos = mysqli_fetch_assoc($aktualis_varos)) { ?>
						<option value="<?php echo $row_aktualis_varos['varos']; ?>" <?php if ($row_aktualis_varos['varos']==$_POST['varos']) echo "selected"; ?>><?php echo $row_aktualis_varos['varos']; ?></option> 
						<?php } ?>
					</select>
                </div>				
              </div> 
			  
              <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span>
				<h3>Más információ</h3>
                <p class="c-hitlist__label">Nyaralóvendégek</p> 
                <div class="stepper__wrapper">
					<select name="ar_osszes_ferohely" id="ar_osszes_ferohely" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['ar_osszes_ferohely']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<?php for ($i = 1; $i <= 25; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if ($_REQUEST['ar_osszes_ferohely']==$i) echo 'selected="selected"'; ?>><?php echo $i; ?></option> 
						<?php } ?>
					</select>
                </div>
				<p class="c-hitlist__label">Gyerekek száma</p> 
                <div class="stepper__wrapper">
					<select name="gyerek_szama_max" id="gyerek_szama_max" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['gyerek_szama_max']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<?php for ($i = 1; $i <= 25; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if ($_REQUEST['gyerek_szama_max']==$i) echo 'selected="selected"'; ?>><?php echo $i; ?></option> 
						<?php } ?>
					</select>
                </div>				
                <p class="c-hitlist__label">Hálószoba</p> 
                <div class="stepper__wrapper">
					<select name="haloszobak_szama" id="haloszobak_szama" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['haloszobak_szama']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<?php for ($i = 1; $i <= 5; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if ($_REQUEST['haloszobak_szama']==$i) echo 'selected="selected"'; ?>><?php echo $i; ?></option> 
						<?php } ?>
					</select>
                </div>
				<p class="c-hitlist__label">Szobák</p> 
                <div class="stepper__wrapper">
					<select name="szobak_szama" id="szobak_szama" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['szobak_szama']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<?php for ($i = 1; $i <= 5; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if ($_REQUEST['szobak_szama']==$i) echo 'selected="selected"'; ?>><?php echo $i; ?></option> 
						<?php } ?>
					</select>
                </div>
				<?php /*
                <p class="c-hitlist__label">Fürdőszoba</p> 
                <div id="furdoszoba" class="stepper__wrapper">
					<select name="furdoszobak_szama" id="furdoszobak_szama" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
						<option value="0" <?php if ($_REQUEST['furdoszobak_szama']==0) echo 'selected="selected"'; ?>>Válasszon</option> 
						<?php for ($i = 1; $i <= 10; $i++) { ?>
						<option value="<?php echo $i; ?>" <?php if ($_REQUEST['furdoszobak_szama']==$i) echo 'selected="selected"'; ?>><?php echo $i; ?></option> 
						<?php } ?>
					</select>
                </div>
				*/ ?>
              </div> 
			  <?php /*
              <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span> 
                <p class="c-hitlist__label">Szállás típusa
                </p> 
                <select name="kategoria_id" id="kategoria_id" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
                  <option value="0">Válasszon</option>
				  <?php while ($row_aktualis_inagtlan_kategoria = mysqli_fetch_assoc($aktualis_inagtlan_kategoria)) { ?>
				  <option value="<?php echo $row_aktualis_inagtlan_kategoria['id']; ?>" <?php if ($row_aktualis_inagtlan_kategoria['id']==$_REQUEST['kategoria_id']) echo "selected"; ?>><?php echo $row_aktualis_inagtlan_kategoria['nev']; ?></option>
				  <?php } ?>
                </select>
              </div>  
			  */ ?>
			  <?php /*
              <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span> 
                <p class="c-hitlist__label">Medence
                </p> 
                <select name="medence" id="medence" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
                  <option value="0">válasszon</option> 
                  <option value="7_118" <?php if ($_REQUEST['medence']=="7_118") echo "selected"; ?>>Beltéri medence</option>
				  <option value="7_119" <?php if ($_REQUEST['medence']=="7_119") echo "selected"; ?>>Kültéri medence</option>
                </select>
              </div> 
			  */ ?>
              <div id="petsDiv" class="c-hitlist__searchrefinement__filterGroup parent__active">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span>
				<h3>Általános információk</h3>
				<p class="c-hitlist__label">Kilátás a Balatonra
                </p> 
                <select name="kilatas_a_balatonra" id="kilatas_a_balatonra" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
                  <option value="">Válasszon</option> 
                  <option value="10_21" <?php if ($_REQUEST['kilatas_a_balatonra']=="10_21") echo "selected"; ?>>Balatoni teljes panoráma</option>
				  <option value="10_23" <?php if ($_REQUEST['kilatas_a_balatonra']=="10_23") echo "selected"; ?>>Nincs kilátás a Balatonra</option>
				  <option value="10_22" <?php if ($_REQUEST['kilatas_a_balatonra']=="10_22") echo "selected"; ?>>Rálátás a Balatonra</option>
                </select>
				<div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Luxus         	 			
                    <input type="checkbox" name="luxus" id="luxus" value="1" <?php if ($_REQUEST['luxus']==1) echo "checked"; ?>>
                  </label>
                </div>				
                <div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Kutya         	 			
                    <input type="checkbox" name="kutyabarat" id="kutyabarat" value="1" <?php if ($_REQUEST['kutyabarat']==1) echo "checked"; ?>>
                  </label>
                </div>
				<div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Saját strand         	 			
                    <input type="checkbox" name="sajat_strand" id="sajat_strand" value="1" <?php if ($_REQUEST['sajat_strand']==1) echo "checked"; ?>>
                  </label>
                </div>
				<div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Last Minute     	 			
                    <input type="checkbox" name="last_minute" id="last_minute" value="1" <?php if ($_REQUEST['last_minute']==1) echo "checked"; ?>>
                  </label>
                </div>
				<div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Erkély/terasz     	 			
                    <input type="checkbox" name="erkely_terasz" id="erkely_terasz" value="1" <?php if ($_REQUEST['erkely_terasz']==1) echo "checked"; ?>>
                  </label>
                </div>
				<p class="c-hitlist__label">Stég
                </p> 
                <select name="steg" id="steg" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
                  <option value="">Válasszon</option> 
                  <option value="1_28" <?php if ($_REQUEST['steg']=="1_28") echo "selected"; ?>>Napozóstég</option>
				  <option value="1_27" <?php if ($_REQUEST['steg']=="1_27") echo "selected"; ?>>Horgászstég</option>
                </select>				
              </div>  
			  <div class="c-hitlist__searchrefinement__filterGroup parent__active">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span>
				<h3>Felszereltség</h3>	
				<div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Mosógép         	 			
                    <input type="checkbox" name="mosogep" id="mosogep" value="1" <?php if ($_REQUEST['mosogep']==1) echo "checked"; ?>>
                  </label>
                </div>
				<div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Légkondicionálás         	 			
                    <input type="checkbox" name="legkondicionalas" id="legkondicionalas" value="1" <?php if ($_REQUEST['legkondicionalas']==1) echo "checked"; ?>>
                  </label>
                </div>
				<div class="c-hitlist__checkbox checkbox">
                  <label id="pets" class="checkbox__label">
					Fűtés         	 			
                    <input type="checkbox" name="futes" id="futes" value="1" <?php if ($_REQUEST['futes']==1) echo "checked"; ?>>
                  </label>
                </div>
              </div>  
			  <?php /*
              <div class="c-hitlist__searchrefinement__filterGroup c-hitlist__searchrefinement__filterGroup--folded parent__active">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span> 
                <p id="equipment" class="c-hitlist__label c-hitlist__select">Jellemzők választása
                </p> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="wlan" class="checkbox__label  icon icon--wifi">
                    <span>35472
                    </span>WiFi 			
                    <input type="checkbox" name="wlan" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="aircondition" class="checkbox__label icon icon--klima">
                    <span>11218
                    </span>Légkondicionáló 			
                    <input type="checkbox" name="aircondition" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="parking" class="checkbox__label icon icon--parkplatz">
                    <span>22567
                    </span>Parkoló 			
                    <input type="checkbox" name="parking" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="balcony_or_terrace" class="checkbox__label icon icon--balkon">
                    <span>31502
                    </span>Terasz 			
                    <input type="checkbox" name="balcony_or_terrace" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="dishwasher" class="checkbox__label icon icon--geschirrspueler">
                    <span>27541
                    </span>Mosogatógép 			
                    <input type="checkbox" name="dishwasher" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="washingmachine" class="checkbox__label icon icon--waschmaschine">
                    <span>30038
                    </span>Mosógép 			
                    <input type="checkbox" name="washingmachine" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="tv" class="checkbox__label icon icon--tv">
                    <span>43251
                    </span>TV 			
                    <input type="checkbox" name="tv" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="sea_or_lake_view" class="checkbox__label icon icon--view">
                    <span>6047
                    </span>Balatoni panoráma			
                    <input type="checkbox" name="sea_or_lake_view" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="bbq" class="checkbox__label icon icon--grill">
                    <span>21298
                    </span>BBQ 			
                    <input type="checkbox" name="bbq" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="cots_1_any" class="checkbox__label icon icon--babybett">
                    <span>19688
                    </span>Gyerekágy 			
                    <input type="checkbox" name="cots" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="whirlpool" class="checkbox__label icon icon--jacuzzi">
                    <span>3939
                    </span>Jacuzzi 			
                    <input type="checkbox" name="whirlpool" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="fireplace" class="checkbox__label icon icon--feuer">
                    <span>12582
                    </span>Kandalló			
                    <input type="checkbox" name="fireplace" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="sauna" class="checkbox__label icon icon--sauna">
                    <span>6277
                    </span>Szauna 			
                    <input type="checkbox" name="sauna" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 
                <div class="c-hitlist__checkbox checkbox" style="display: none;">
                  <label id="wheelchair" class="checkbox__label icon icon--rollstuhl">
                    <span>138
                    </span>Akadálymentesített 			
                    <input type="checkbox" name="wheelchair" value="true" data-tracked="true" data-1st-state="false">
                  </label>
                </div> 

              </div> 
              <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span> 
                <p class="c-hitlist__label">Ajánlatok
                </p> 
                <select id="offer_slct" name="offer_slct" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
                  <option value="" selected="selected">válasszon
                  </option> 
                  <option value="last_minute" id="last_minute">Utolsó ajánlatok (2870)
                  </option> 
                  <option value="special_offer" id="special_offer">Minden különleges ajánlat (7514)
                  </option> 
                  <option value="selection" id="selection">Exkluzív és luxus (862)
                  </option> 
                  <option value="discount-20" id="discount_20">≥ 20% kedvezmény (4494)
                  </option> 
                  <option value="cheapcheap" id="cheapcheap">Egyszerű és olcsó (2679)
                  </option> 
                  <option value="early_booker" id="early_booker">Korai foglalási kedvezmény (2124)
                  </option>
                </select>
              </div>  
              <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span> 
                <p class="c-hitlist__label">Nyaralás típusa
                </p> 
                <select id="holidaytype_slct" name="holidaytype_slct" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
                  <option value="" selected="selected">válasszon
                  </option> 
                  <option value="familyfriendly" id="familyfriendly">Család barát (4823)
                  </option> 
                  <option value="holiday_resort" id="holiday_resort">Üdülőhely (5565)
                  </option> 
                  <option value="residence" id="residence">Apartman ház (4335)
                  </option> 
                  <option value="citytrips" id="citytrips">Belvárosi (1040)
                  </option> 
                  <option value="utoring" id="utoring">Vízparti szállás  (439)
                  </option>
                </select>
              </div> 
              <div class="c-hitlist__searchrefinement__filterGroup">
                <span class="c-hitlist__searchrefinement__filterGroup__spacer">
                </span> 
                <p class="c-hitlist__label">Tevékenységek
                </p> 
                <select id="activities" name="activities" class="c-hitlist__select parent__active" data-tracked="true" style="opacity: 1; pointer-events: auto;">
                  <option value="" selected="selected">válasszon
                  </option> 
                  <option value="hiking" id="hiking">Túrázás (19698)
                  </option> 
                  <option value="golf" id="golf">Golf (13010)
                  </option> 
                  <option value="biking_plains" id="biking_plains">Kerékpár (12119)
                  </option> 
                  <option value="wellness" id="wellness">Wellness (6633)
                  </option> 
                  <option value="tennis" id="tennis">Tenisz (18077)
                  </option> 
                  <option value="surfing" id="surfing">Szörf (9718)
                  </option> 
                  <option value="sailing" id="sailing">Vitorlázás (10962)
                  </option> 
                  <option value="riding" id="riding">Lovaglás (10613)
                  </option> 
                </select>
              </div> 
              */ ?>
              
			  <div id="applyFilter" class="c-hitlist__searchrefinement__filterGroup c-hitlist__searchrefinement__applyFilter" style="display: block;">
                  <button type="button" name="cbAction" class="btn btn--search waves-effect" onclick="onSubmit();">Keresés indítása</button>
              </div>
          
          </div> 
        </div> 
        <div class="viewToggle__wrapper">
          <div id="viewToggle__filter" class="viewToggle">
            <span class="viewToggle__item viewToggle__item--highlight viewToggle__item--filter icon icon--slider--white  webcc_filter_button">						refine search 					
            </span>
          </div> 
          <div id="viewToggle__sort" class="viewToggle">
            <div class="c-hitlist__topbar__sort__wrapper">
              <label class="c-hitlist__topbar__sort__label">Sort by
              </label> 
              <select id="result_sorting1" name="result_sorting1" class="c-hitlist__topbar__dropdown c-hitlist__topbar__dropdown--sort" data-tracked="true">
                <option value="descszallashelyek/apartmanok_files" selected="selected">Our recommendations
                </option> 
                <option value="descLastBookDay">Best Sellers
                </option> 
                <option value="ascAge">Newest first
                </option> 
                <option value="descAverageRating">Customer Reviews
                </option> 
                <option value="ascPrice">Price (low...high)
                </option> 
                <option value="descPrice">Price (high...low)
                </option> 
                <option value="ascPerson">Number of persons (ascending)
                </option> 
                <option value="descPerson">Number of persons (descending)
                </option>
              </select>
            </div>
          </div> 
        </div>
      </section>
</form>	  
<script type="text/javascript">

function onSubmit() {
	
	$('#k').val(1);
	$('#form').submit();
	
}
	  
        $('.owl-carousel').owlCarousel({
          loop: true,
          margin: 0,
          items: 1,
          nav: true,
          navText: ['<a class="unslider-arrow prev">Prev</a>','<a class="unslider-arrow next">Next</a>']          
        });
        $(document).ready(function() {
			
          var owlHeight = $('.owl-stage-outer').outerHeight();
		  $('.owl-carousel').css('height', owlHeight);
          
		  setTimeout(function(){ 
            $('.owl-carousel').css('height', owlHeight);
          }, 10);
		  
		  
        });
      </script>
