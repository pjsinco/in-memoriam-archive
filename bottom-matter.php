
			</div>
		</div>
	</div>
	<div id="post_sidebar_inmemdb" class="sidebar">
		<div id="sidebar8">
			<h2 class="widgettitle"><strong>In Memoriam:</strong><br /> Two-year archive</h2>
			<p><strong>Search by school</strong></p>
			<form name="school_choice" action="./inmem-db-school.php" method="get">
                <p><select name="school">
				<?php $collection->printDropdownBySchool(); ?>
                </select></p>
				<input type="submit" name="submit" value="Search" id="submit"); />
				<p><input type="hidden" value="0" name="process-form" /></p>
			</form>
			<p><strong>Search all schools by graduation year</strong></p>
			<form name="year_choice" action="" method="get">
				<select name="year">
					<?php $collection->printDropdownByYear(); ?>
				</select>
				<input type="submit" name="submit" value="Search" id="submit"); />
				<input type="hidden" value="0" name="process-form" />
			</form>
		</div>
			<div id="sidebar5">
				<ul id="sidebar">
					<?php
					 	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar()) : ?>
							<h2>Monthly Archives</h2>
					<?php endif; ?>
				</ul>
				<?php include (TEMPLATEPATH . '/sidebar10.php'); ?>
			</div><!-- end sidebar5 -->
	</div>
	<?php get_sidebar('ads'); ?>
</div>	

<?php get_footer(); ?>
