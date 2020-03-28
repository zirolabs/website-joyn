

  <main id="main">

<!-- ***** Special Area Start ***** -->
<section class="special-area bg-white section_padding_100" id="register">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Section Heading Area -->
				<div class="section-heading text-center">
					<h1>J-Mart</h1>
					<div class="line-shape"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<form class="form-horizontal" method="POST" action="Regis/upload_mmart"  enctype="multipart/form-data">
					<input name="redirect" type="hidden" value="<?php echo base_url()?>J-Mart" />
					<!-- <input type="hidden" name="job" value="1"> -->
					<input type="hidden" name="jenis_lapak" value="1">
					<div class="row">
						<div class="col-md-12 form-group">
							<label>Owner Name</label>
							<input type="text" placeholder="Owner Name" class="form-control" name="nama_pemilik_toko">
						</div>

						<div class="col-md-12 form-group">
							<label>The name of the person in charge</label>
							<input type="text" placeholder="The name of the person in charge" name="nama_penanggung_jawab" class="form-control">
						</div>

					</div>

					<div class="row">
						<div class="col-md-12 form-group">
							<label>identity(ID Card,Driving License,PASPORT)</label>
							<select name="jenis_identitas" class="form-control">
								<option default>Pilih Tipe</option>
								<option>ID CARD</option>
								<option>Driving License</option>
								<option>PASPORT</option>
							</select>
							<!-- <input type="text" placeholder="nama akhir" class="form-control" name="nama_belakang" required> -->
						</div>

						<div class="col-md-12 form-group">
							<label>ID.No</label>
							<input type="text" placeholder="no.identitas" name="no_identitas" class="form-control" >
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 form-group">
							<label>Company Address</label>
							<input type="text" placeholder="Company Address" name="alamat_pemilik" class="form-control">
						</div>

						<div class="col-md-12 form-group">
							<label>City</label>
							<input type="text" placeholder="City" name="kota" class="form-control">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 form-group">
							<label>Phone</label>
							<input type="tel" placeholder="phone" name="telepon_penanggung_jawab" class="form-control">
						</div>

						<div class="col-md-12 form-group">
							<label>Email</label>
							<input type="email" placeholder="email" name="email_penanggung_jawab" class="form-control">
						</div>
					</div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Retype Password</label>
                            <input type="password" name="password2" class="form-control" id="password2" placeholder="Repeat Password" autocomplete="off">
                        </div>
                    </div>
 

				<div class="row">
					<div class="col-12">
						<!-- Section Heading Area -->
						<div class="section-heading text-center">
							<h1>Personal Info</h1>
							<div class="line-shape"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Market Name</label>
						<input type="text" placeholder="Market Name" class="form-control" name="nama_toko">
					</div>

					<div class="col-md-12 form-group">
						<label>Category</label>

						<select name="kategori" class="form-control">
							<option default>Select Category Market</option>
							<?php foreach ($jenis as $j) {
								?>
								<option value="<?php echo $j['id'] ?>"><?php echo $j['kategori'] ?></option>
								<?php
                    # code...
							} ?>
                 <!--  <option value="2">toko Padang</option>
                 	<option value="1">toko Mahal</option> -->

                 </select>
             </div>

             <div class="col-md-4 form-group">
             	<label>Phone</label>
             	<input type="tel" placeholder="Phone" name="telepon_toko" class="form-control">
             </div>

             <div class="col-md-4 form-group">
             	<label>Opening</label>
             	<!--<input type="time" class="form-control" name="jam_buka">-->
             	<select class="form-control" name="jam_buka">
             		<option value="01:00">01:00</option>
             		<option value="01:30">01:30</option>

             		<option value="02:00">02:00</option>
             		<option value="02:30">02:30</option> 

             		<option value="03:00">03:00</option>
             		<option value="03:30">03:30</option>

             		<option value="04:00">04:00</option>
             		<option value="04:30">04:30</option>

             		<option value="05:00">05:00</option>
             		<option value="05:30">05:30</option>

             		<option value="06:00">06:00</option>
             		<option value="06:30">06:30</option>

             		<option value="07:00">07:00</option>
             		<option value="07:30">07:30</option>

             		<option value="08:00">08:00</option>
             		<option value="08:30">08:30</option>

             		<option value="09:00">09:00</option>
             		<option value="09:30">09:30</option>

             		<option value="10:00">10:00</option>
             		<option value="10:30">10:30</option>

             		<option value="11:00">11:00</option>
             		<option value="11:30">11:30</option>

             		<option value="12:00">12:00</option>
             		<option value="12:30">12:30</option>

             		<option value="13:00">13:00</option>
             		<option value="13:30">13:30</option>

             		<option value="14:00">14:00</option>
             		<option value="14:30">14:30</option>

             		<option value="15:00">15:00</option>
             		<option value="15:30">15:30</option>

             		<option value="16:00">16:00</option>
             		<option value="16:30">16:30</option>

             		<option value="17:00">17:00</option>
             		<option value="17:30">17:30</option>

             		<option value="18:00">18:00</option>
             		<option value="18:30">18:30</option>

             		<option value="19:00">19:00</option>
             		<option value="19:30">19:30</option>

             		<option value="20:00">20:00</option>
             		<option value="20:30">20:30</option>

             		<option value="21:00">21:00</option>
             		<option value="21:30">21:30</option>

             		<option value="22:00">22:00</option>
             		<option value="22:30">22:30</option>

             		<option value="23:00">23:00</option>
             		<option value="23:30">23:30</option>

             		<option value="23:59">23:59</option>
             	</select>
             </div>

             <div class="col-md-4 form-group">
             	<label>Closed</label>
             	<!--<input type="time" class="form-control" name="jam_tutup">-->
             	<select class="form-control" name="jam_tutup">
             		<option value="01:00">01:00</option>
             		<option value="01:30">01:30</option>

             		<option value="02:00">02:00</option>
             		<option value="02:30">02:30</option> 

             		<option value="03:00">03:00</option>
             		<option value="03:30">03:30</option>

             		<option value="04:00">04:00</option>
             		<option value="04:30">04:30</option>

             		<option value="05:00">05:00</option>
             		<option value="05:30">05:30</option>

             		<option value="06:00">06:00</option>
             		<option value="06:30">06:30</option>

             		<option value="07:00">07:00</option>
             		<option value="07:30">07:30</option>

             		<option value="08:00">08:00</option>
             		<option value="08:30">08:30</option>

             		<option value="09:00">09:00</option>
             		<option value="09:30">09:30</option>

             		<option value="10:00">10:00</option>
             		<option value="10:30">10:30</option>

             		<option value="11:00">11:00</option>
             		<option value="11:30">11:30</option>

             		<option value="12:00">12:00</option>
             		<option value="12:30">12:30</option>

             		<option value="13:00">13:00</option>
             		<option value="13:30">13:30</option>

             		<option value="14:00">14:00</option>
             		<option value="14:30">14:30</option>

             		<option value="15:00">15:00</option>
             		<option value="15:30">15:30</option>

             		<option value="16:00">16:00</option>
             		<option value="16:30">16:30</option>

             		<option value="17:00">17:00</option>
             		<option value="17:30">17:30</option>

             		<option value="18:00">18:00</option>
             		<option value="18:30">18:30</option>

             		<option value="19:00">19:00</option>
             		<option value="19:30">19:30</option>

             		<option value="20:00">20:00</option>
             		<option value="20:30">20:30</option>

             		<option value="21:00">21:00</option>
             		<option value="21:30">21:30</option>

             		<option value="22:00">22:00</option>
             		<option value="22:30">22:30</option>

             		<option value="23:00">23:00</option>
             		<option value="23:30">23:30</option>

             		<option value="23:59">23:59</option>
             	</select>
             </div>
         </div>

         <div class="row">
         	<div class="col-md-12 form-group">
         		<label>Address</label>
         		<input type="text" placeholder="Address" name="alamat_toko" class="form-control">
         	</div>

         	<div class="col-md-12 form-group">

         		<label>Location</label>
         		<input type="text" class="form-control" id="us3-address" placeholder="isi lokasi anda" />

         	</div>
         </div>

         <div class="row">
         	<div class="col-md-12 form-group">
         		<label>Latitude</label>
         		<input type="text" name="latitude" class="form-control" id="us3-lat" />
         	</div>

         	<div class="col-md-12 form-group">
         		<label>Longitude</label>
         		<input type="text" name="longitude" class="form-control" id="us3-lon"/>
         	</div>
         </div>

         <div class="col-md-12 form-group">
         	<div id="us3" style="width: 100%; height: 400px;"></div>
         </div>


         <div class="form-group">
         	<label>Description Market</label>
         	<textarea placeholder="pesan" name="deskripsi_toko" rows="6" style="resize:none;" class="form-control"></textarea>
         </div>


         <div class="form-group text-center">
         	<button name="submit" type="submit" class="btn btn-success">Signup</button>
         	<button name="cancel" type="reset" class="btn btn-success">Cancel</button>
         </div>
     </form>
 </div>
</div>
</div>
</section>
</main>