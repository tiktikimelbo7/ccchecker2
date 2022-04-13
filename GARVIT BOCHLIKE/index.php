<?php
//Script Author: ᴛɪᴋᴏʟ4ʟɪғᴇ https://t.me/Tikol4Life
	include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- BASIC DATA -->
	<meta charset="utf-8">
	<title><?php echo $site_name;?></title>
	<meta name="author" content="<?php echo $owner ?>">
	<link rel="icon" href="<?php echo $site_icon; ?>" type="image/png">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $owner ?> CC Checker">
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body onload="ccgen();"style="background: #212121;">
	<audio id="click" src="assets/sfx/click.mp3"></audio>
	<audio id="error" src="assets/sfx/error.mp3"></audio>
	<audio id="success" src="assets/sfx/success.mp3"></audio>
	<div class="container" id="container">
		<!-- START OF IMAGE HEADER -->
		<div class="row justify-content-md-center">
			<div class="col-md">
				<center>
					<img class="rounded-circle" src="<?php echo $site_icon; ?>" width="200" height="200" style="margin-top: 40px;" onclick="modalCCGEN();">
				</center>
			</div>
		</div>
		<!-- END OF IMAGE HEADER -->
		<!-- START OF FORMS -->
		<div class="row justify-content-md-center" style="margin-top: 40px;">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form>
					<div class="form-group">
						<label for="cards" style="color: #FFFFFF; margin-left: 20px">Generated Cards</label>
						<textarea class="form-control" style="background: transparent;color: #FFFFFF;overflow:hidden" id="cards" rows="5" placeholder="xxxxxxxxxxxxxxxx|xx|xxxx|xxx" required></textarea>
					</div>
					<div class="form-group">
						<label for="sk" style="color: #FFFFFF; margin-left: 20px">API</label>
						<select class="form-control" id="api" style="background: transparent;color: #FFFFFF;">
							<?php for ($i=0; $i < count($api_file); $i++) {
								echo '<option style="background: #212121" value="'.$api_file[$i].'">'.$api_name[$i].'</option>';
							}?>	
					    </select>
					</div>
					<div class="form-group">
						<label for="sk" style="color: #FFFFFF; margin-left: 20px">Stripe Secret Key (SK)</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" style="background: transparent;color: #FFFFFF;" id="sk" aria-describedby="sk" placeholder="sk_live_xxxxxxxxxxxxxxxxxx">
							<div class="input-group-append">
								<button class="btn btn-outline-danger" type="button" onclick="copySK();">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clipboard" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  										<path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
  										<path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
									</svg>
								</button>
								<button class="btn btn-outline-danger" type="button" onclick="checkSK();">CHECK SK</button>
							</div>
						</div>
					</div>
					<button style="margin-top: 20px" type="button" class="btn btn-outline-danger btn-block" onclick="checkCards();">CHECK CARDS</button>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row justify-content-md-center" style="margin-top: 40px;">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form>
					<div class="form-group">
						<div class="row">
							<div class="col-4">
								<button id="cardsLiveCVV" name="cardsLiveCVV" type="button" class="btn btn-outline-primary btn-block">ᴄᴠᴠ : <span id="approved_counter_cvv">0</span></button>
								<div class="row">
									<div class="col-4 col-sm-4"></div>
									<div class="col-8 col-sm-8">
										<button type="button" style="margin-top: 10px;" name="clear_cvv" id="clear_cvv" class="btn btn-danger btn-sm btn-block" onclick="clearCVV();">Clear CVV</button>
									</div>
								</div>
							</div>
							<div class="col-4">
								<button id="cardsLiveCCN" name="cardsLiveCCN" type="button" class="btn btn-outline-warning btn-block">ᴄᴄɴ : <span id="approved_counter_ccn">0</span></button>
								<div class="row">
									<div class="col-4 col-sm-4"></div>
									<div class="col-8 col-sm-8">
										<button type="button" style="margin-top: 10px;" name="clear_ccn" id="clear_ccn" class="btn btn-danger btn-sm btn-block" onclick="clearCCN();">Clear CCN</button>
									</div>
								</div>
							</div>
							<div class="col-4">
								<button id="cardsDead" name="cardsDead" type="button" class="btn btn-outline-danger btn-block">ᴅᴇᴀᴅ : <span id="decline_counter">0</span></button>
								<div class="row">
									<div class="col-4 col-sm-4"></div>
									<div class="col-8 col-sm-8">
										<button type="button" style="margin-top: 10px;" name="clear_dead" id="clear_dead" class="btn btn-danger btn-sm btn-block" onclick="clearDead();">Clear DEAD</button>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row justify-content-md-center" >
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form>
					<div class="form-group" style="margin-left: 40px;margin-right: 40px;">
						<div class="results" id="results">
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
		<!-- END OF FORMS -->
		<div class="footer" id="footer"><center><p style="color: #FFFFFF">GARVIT_XD EDITED BY @HACKER2217</p></center></div>
	</div>
	<!-- START OF CCGEN MODAL -->
	<div class="modal fade" id="ccGEN" role="dialog" aria-hidden="true" >
		<div class="modal-dialog modal-dialog-centered"  style="background: transparent;">
			<div class="modal-content" style="background: transparent;">
				<div class="modal-body" style="background: #212121">
					<center style="margin-bottom: 20px">
						<img class="rounded-circle" src="<?php echo $site_icon; ?>" width="200" height="200" style="margin-top: 10px;margin-bottom: 20px;" >
						<h5 class="modal-title" id="exampleModalCenterTitle" style="color: #ffffff">CC Generator</h5>
					</center>
					<form name="console" id="console" role="form" method="POST">
						<div>
							<div class="row">
								<div class="col-8 col-lg-8">
									<div class="form-group">
										<label class="form-control-label text-white" style="margin-left: 10px" for="inputbin">BIN</label>
										<input id="ccpN" name="ccp" maxlength="19" type="text" id="inputbin" class="form-control text-white" style="background: transparent;" placeholder="xxxx xxxx xxxx xxxx">
									</div>
								</div>
								<div class="col-4 col-lg-4">
									<div class="form-group">
										<label class="form-control-label text-white" style="margin-left: 10px" for="inputcvv">CVV</label>
										<input type="text" id="eccv" name="eccv" style="background: transparent;" class="form-control text-white" placeholder="rnd" value="rnd">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-4 col-lg-4">
									<div class="form-group">
										<select name="ccoudatfmt" class="input_text" style="display:none;">
											<option value="CHECKER" selected="selected">CHK</option>
											<option value="CSV">CSV</option>
											<option value="XML">XML</option>
											<option value="JSON">JSON</option>
										</select>
										<input type="hidden" name="tr" value="1000">
										<input type="hidden" name="L" style="width: 20px" value="1L">
										<div type="hidden" id="bininfo" align="center"></div>
										<label class="form-control-label text-white" style="margin-left: 10px" for="inputmonth">MONTH</label>
										<select class="form-control text-white" style="background: transparent;" name="emeses">
											<option style="background: #212121" value="rnd">RANDOM  </option>
											<option style="background: #212121" value="01">01 - JAN</option>
											<option style="background: #212121" value="02">02 - FEB</option>
											<option style="background: #212121" value="03">03 - MAR</option>
											<option style="background: #212121" value="04">04 - APR</option>
											<option style="background: #212121" value="05">05 - MAY</option>
											<option style="background: #212121" value="06">06 - JUN</option>
											<option style="background: #212121" value="07">07 - JUL</option>
											<option style="background: #212121" value="08">08 - AUG</option>
											<option style="background: #212121" value="09">09 - SEP</option>
											<option style="background: #212121" value="10">10 - OCT</option>
											<option style="background: #212121" value="11">11 - NOV</option>
											<option style="background: #212121" value="12">12 - DEC</option>
										</select>
									</div>
								</div>
								<div class="col-4 col-lg-4">
									<div class="form-group">
										<label class="form-control-label text-white" style="margin-left: 10px" for="inputyear">YEAR</label>
										<select class="form-control text-white" style="background: transparent;" name="eyear">
											<option style="background: #212121" value="rnd">RANDOM</option>
											<option style="background: #212121" value="2020">2020</option>
											<option style="background: #212121" value="2021">2021</option>
											<option style="background: #212121" value="2022">2022</option>
											<option style="background: #212121" value="2023">2023</option>
											<option style="background: #212121" value="2024">2024</option>
											<option style="background: #212121" value="2025">2025</option>
											<option style="background: #212121" value="2026">2026</option>
											<option style="background: #212121" value="2027">2027</option>
											<option style="background: #212121" value="2028">2028</option>
											<option style="background: #212121" value="2029">2029</option>
											<option style="background: #212121" value="2030">2030</option>
										</select>
									</div>
								</div>
								<div class="col-4  col-lg-4">
									<div class="form-group">
										<label class="form-control-label text-white" style="margin-left: 10px" for="inputquantity">QUANTITY</label>
										<input type="number" name="ccghm" style="background: transparent;" maxlength="4" class="form-control text-white" value="10">
										<select name="ccnsp" class="input_text" style="display:none;">
											<option selected="selected">None</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<button type="button" style="margin-right: 20px;margin-left: 20px;" class="btn btn-outline-danger btn-block"  name="gerar" id="gerar" onclick="playClick();">GENERATE</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF CCGEN MODAL -->
	<!-- START OF TEMPLATE MODAL -->
	<div class="modal fade" id="Modal" data-keyboard="false" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered">
			<div class="modal-content" style="background: #212121">
				<div class="modal-body" style="background: #212121">
					<center style="margin-bottom: 20px">
						<img class="rounded-circle" src="<?php echo $site_icon; ?>" width="200" height="200" style="margin-top: 10px;margin-bottom: 20px;" >
						<h5 class="modal-title" id="ModalTitle" style="color: #ffffff"></h5>
						<span id="ModalMsg" style="color: #ffffff;margin-top: 20px"></span>
					</center>
				</div>
			</div>
		</div>
	</div>
	<!-- END OF TEMPLATE MODAL -->
	<!-- BOOTSTRAP PLUGIN SCRIPTS-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<!-- CHECKER PLUGIN SCRIPTS-->
	<script src="assets/js/Tikol4Life.js"></script>
</body>
</html>
