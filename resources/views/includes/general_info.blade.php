
<input type="hidden" name="group_id" value="0">

<!-- Firstname -->
<label for="fname"><strong>First Name</strong></label>
<input type="text" id="fname" name="firstname" class="form-control mb-3" placeholder="First Name" autocomplete="on" required>
<!-- Lastname -->
<label for="lname"><strong>Last Name</strong></label>
<input type="text" id="lname" name="lastname" class="form-control mb-3" placeholder="Last Name" autocomplete="on" required>
<!-- E-Male -->
<label for="email"><strong>E-mail</strong></label>
<input type="email" id="email" name="email" class="form-control mb-3" placeholder="E-mail" autocomplete="on" required>

<div class="row">
    <div class="col-6">
        <!-- Phone-number -->
        <label for="phone"><strong>Mobile Number</strong></label>
        <input type="tel" id="phone" name="phone" class="form-control mb-3" autocomplete="on" required> 
    </div>
    <div class="col-6">
        <!-- DOB-->
        <label for="phone"><strong>Date of Birth</strong></label>
        <input type="date" id="dob" name="dob" class="form-control mb-3" autocomplete="off" required>
    </div>
</div>

<div class="row">
    <div class="col-lg-12" style="display: block"><label><strong>Gender</strong></label></div>
    <div class="col-6">
        <!-- Default checked -->
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="male" name="gender" value="1">
            <label class="custom-control-label" for="male">Male</label>
        </div>
    </div>
    <div class="col-6">
        <!-- Default unchecked -->
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="female" name="gender" value="0">
            <label class="custom-control-label" for="female">Female</label>
        </div>
    </div>
</div>



