<!-- Start Quick Contact Form -->
<section class="bg-dark text-white mt--15">
	<div class="absolute-full w-100 overflow-hidden opacity-9"><img alt="..." class="img-fluid" height="2000" src="../assets/images/masks/shape-line-lense.svg" width="2000"></div>
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-4 mb-4">
				<div class="mb-4" data-aos="fade-down" data-aos-duration="0" data-aos-delay="0"><img class="lazyload img-fluid" alt="Float The Flop Logo" data-src="../assets/images/float-logo/float-the-flop-logo-white-text-transparent.svg" width="370" height="106"></div>
				<div data-aos="fade-up" data-aos-duration="0" data-aos-delay="0">
					<strong>24/7 Player Support Desk</strong>
					<hr class="bg-gray-800">
				</div>
				<div data-aos="flip-left" data-aos-duration="0" data-aos-delay="0">
					<p><strong>Non-Members</strong>: Please contact us using the quick contact form or the live support option at the bottom of this page.<br>Alternatively, email:<br><a href="mailto:support&#64;float-the-flop.com">support&#64;float-the-flop.com</a></p>
					<hr class="bg-gray-800">
				</div>
				<div data-aos="flip-right" data-aos-duration="0" data-aos-delay="0">
					<p><strong>Members</strong>: Please lodge a support ticket from within your Player Portal.</p>
					<hr class="bg-gray-800">
				</div>
				<div data-aos="flip-left" data-aos-duration="0" data-aos-delay="0">
					<p><strong>Business Partners</strong>: Please contact us via your Client Portal or email:<br><a href="mailto:back.office&#64;float-the-flop.com">back.office&#64;float-the-flop.com</a></p>
				</div>
			</div>
			<div class="col-12 col-lg-8 p--20" data-aos="flip-right" data-aos-duration="0" data-aos-delay="0">
				<h4>Quick Contact Form</h4>
				<hr class="bg-gray-800">
				<form id="fcf-form-id" method="post" action="../php/contact-form-process.php">
					<div class="form-label-group mb-3">
						<input required placeholder="First Name" id="Name" name="Name" type="text" class="form-control">
						<label for="Name">First Name</label>
					</div>
					<div class="form-label-group mb-3">
						<input required placeholder="Email" id="Email" name="Email" type="email" class="form-control">
						<label for="Email">Email Address</label>
					</div>
					<div class="form-label-group mb-4">
						<textarea required placeholder="Message" id="Message" name="Message" maxlength="1000" class="form-control" rows="3"></textarea>
						<label for="Message">Your Message</label>
					</div>
					<div class="clearfix bg-white position-relative rounded p-4 mb-4"> <span class="text-muted fs--12 d-block position-absolute bottom-0 end-0 m-2">
								EU GDPR
							</span>
						<label class="form-checkbox form-checkbox-primary">
							<input required type="checkbox" name="contact_gdpr"> <i></i> <span class="text-dark"> 	
									I consent that my data is being stored in-line with the guidelines of our <a href="privacy.php" target="_blank">Privacy Policy</a>. 
								</span> </label>
					</div>
					<button type="submit" class="btn btn-primary btn-block"> <i class="fi fi-arrow-end"></i>Send Message </button>
				</form>
			</div>
		</div>
	</div>
</section>
<script>
	document.getElementById('fcf-form-id').reset();
</script>
<!-- End Quick Contact Form -->