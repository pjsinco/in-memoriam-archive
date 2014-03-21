<h2 class="widgettitle"><strong>In Memoriam:</strong><br /> Two-year archive</h2>
<p>
<p>Search for the names of osteopathic physicians and osteopathic medical students who have died in the past two years.</p>
<p><strong>Search by school</strong></p>
<form name="school_choice" action="./inmem-db3.php" method="get">
	<p><select name="school"> 
        <?php $collection->printDropdownBySchool() ?>
	</select></p>
	<input type="submit" name="submit" value="Search" id="submit"); />
	<p><input type="hidden" value="0" name="process-form" /></p>
</form>

<p><strong>Search all schools by graduation year</strong></p>
<form name="year_choice" action="./inmem-db3.php" method="get">
	<select name="year">
		<?php $collection->printDropdownByYear(); ?>
	</select>
	<input type="submit" name="submit" value="Search" id="submit"); />
	<p><input type="hidden" value="0" name="process-form" /></p>
</form>

<p><strong>Search by state of residence</strong></p>
<form name="state_choice" action="./inmem-db3.php" method="get">
	<select name="state">
		<?php $collection->printDropdownByState(); ?>
	</select>
	<input type="submit" name="submit" value="Search" id="submit"); />
	<p><input type="hidden" value="0" name="process-form" /></p>
</form>
