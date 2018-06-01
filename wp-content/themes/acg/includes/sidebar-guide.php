<?php
   $barangay = array('Agapito Del Rosario', 'Amsic', 'Anunas', 'Balibago', 'Capaya', 'Claro M. Recto', 'Cuayan', 'Cutcut', 'Cutud', 'Lourdes North West', 'Lourdes Sur', 'Lourdes Sur East', 'Malabanas', 'Margot', 'Marisol', 'Mining', 'Pampang', 'Pandan', 'Pulungbulo', 'Pulung Cacutud', 'Pulung Maragul', 'Salapungan', 'San Jose', 'San Nicolas', 'Santa Teresita', 'Santa Trinidad', 'Santo Cristo', 'Santo Domingo', 'Santo Rosario', 'Sapalibutad', 'Sapangbato', 'Tabun', 'Virgen Delos Remedios');
?>

<div class="panel panel-default panel-filter-collapse">
  <div class="panel-heading">
    <a href="#bizcat-collapse" data-toggle="collapse" class="cat-collapse">Filter by Category</a>
  </div>
  <div class="collapse in bizcat-list" id="bizcat-collapse">
    <ul>
    <?php if(is_search()) { ?>

      <li><a href="<?php echo site_url('?cat=6&s='.$_GET['s']); ?>"><i class="fa fa-paw icon"></i> Animal Services</a></li>
      <li><a href="<?php echo site_url('?cat=7&s='.$_GET['s']); ?>"><i class="fa fa-suitcase icon"></i> Hotels & Travel</a></li>
      <li><a href="<?php echo site_url('?cat=8&s='.$_GET['s']); ?>"><i class="fa fa-map-marker icon"></i> Tourism</a></li>
      <li><a href="<?php echo site_url('?cat=9&s='.$_GET['s']); ?>"><i class="fa fa-building icon"></i> Real Estate</a></li>
      <li><a href="<?php echo site_url('?cat=10&s='.$_GET['s']); ?>"><i class="fa fa-wrench icon"></i> Local Services</a></li>
      <li><a href="<?php echo site_url('?cat=11&s='.$_GET['s']); ?>"><i class="fa fa-bicycle icon"></i> Leisure</a></li>
      <li><a href="<?php echo site_url('?cat=12&s='.$_GET['s']); ?>"><i class="fa fa-heartbeat icon"></i> Health & Medical</a></li>
      <li><a href="<?php echo site_url('?cat=13&s='.$_GET['s']); ?>"><i class="fa fa-money icon"></i> Financial Services</a></li>
      <li><a href="<?php echo site_url('?cat=14&s='.$_GET['s']); ?>"><i class="fa fa-cut icon"></i> Fashion, Wellness & Beauty</a></li>
      <li><a href="<?php echo site_url('?cat=15&s='.$_GET['s']); ?>"><i class="fa fa-calendar icon"></i> Event Planning</a></li>
      <li><a href="<?php echo site_url('?cat=16&s='.$_GET['s']); ?>"><i class="fa fa-graduation-cap icon"></i> Education</a></li>
      <li><a href="<?php echo site_url('?cat=4&s='.$_GET['s']); ?>"><i class="fa fa-cutlery icon"></i> Food</a></li>
      <li><a href="<?php echo site_url('?cat=17&s='.$_GET['s']); ?>"><i class="fa fa-car icon"></i> Automotive</a></li>
      <li><a href="<?php echo site_url('?cat=18&s='.$_GET['s']); ?>"><i class="fa fa-beer icon"></i> Night Life</a></li>
      <li><a href="<?php echo site_url('?cat=5&s='.$_GET['s']); ?>"><i class="fa fa-shopping-bag icon"></i> Shopping</a></li>
      <li><a href="<?php echo site_url('?cat=3&s='.$_GET['s']); ?>"><i class="fa fa-globe icon"></i> All</a></li>

    <?php } else { ?>

      <li><a href="<?php echo site_url('section/guide/animal-services'); ?>"><i class="fa fa-paw icon"></i> Animal Services</a></li>
      <li><a href="<?php echo site_url('section/guide/hotels-travel'); ?>"><i class="fa fa-suitcase icon"></i> Hotels & Travel</a></li>
      <li><a href="<?php echo site_url('section/guide/tourism'); ?>"><i class="fa fa-map-marker icon"></i> Tourism</a></li>
      <li><a href="<?php echo site_url('section/guide/real-estate'); ?>"><i class="fa fa-building icon"></i> Real Estate</a></li>
      <li><a href="<?php echo site_url('section/guide/local-services'); ?>"><i class="fa fa-wrench icon"></i> Local Services</a></li>
      <li><a href="<?php echo site_url('section/guide/leisure'); ?>"><i class="fa fa-bicycle icon"></i> Leisure</a></li>
      <li><a href="<?php echo site_url('section/guide/health-medical'); ?>"><i class="fa fa-heartbeat icon"></i> Health & Medical</a></li>
      <li><a href="<?php echo site_url('section/guide/financial-services'); ?>"><i class="fa fa-money icon"></i> Financial Services</a></li>
      <li><a href="<?php echo site_url('section/guide/fashion-wellness-beauty'); ?>"><i class="fa fa-cut icon"></i> Fashion, Wellness & Beauty</a></li>
      <li><a href="<?php echo site_url('section/guide/event-planning'); ?>"><i class="fa fa-calendar icon"></i> Event Planning</a></li>
      <li><a href="<?php echo site_url('section/guide/education'); ?>"><i class="fa fa-graduation-cap icon"></i> Education</a></li>
      <li><a href="<?php echo site_url('section/guide/food'); ?>"><i class="fa fa-cutlery icon"></i> Food</a></li>
      <li><a href="<?php echo site_url('section/guide/automotive'); ?>"><i class="fa fa-car icon"></i> Automotive</a></li>
      <li><a href="<?php echo site_url('section/guide/night-life'); ?>"><i class="fa fa-beer icon"></i> Night Life</a></li>
      <li><a href="<?php echo site_url('section/guide/shopping'); ?>"><i class="fa fa-shopping-bag icon"></i> Shopping</a></li>
      <li><a href="<?php echo site_url('section/guide'); ?>"><i class="fa fa-globe icon"></i> All</a></li>

    <?php } ?>
    </ul>
  </div>
</div>

<div class="panel panel-default panel-filter-collapse">
  <div class="panel-heading">
    <a href="#bizadd-collapse" data-toggle="collapse" class="add-collapse">Filter by Barangay</a>
  </div>
  <div class="collapse bizcat-list" id="bizadd-collapse">
    <ul>
    <?php if(is_search()) {
      // 21-53
      $barId = 21;
      foreach($barangay as $bar) {
    ?>
      <li><a href="<?php echo site_url('?cat='.$barId.'&s='.$_GET['s']); ?>"><i class="fa fa-location-arrow icon"></i> <?php echo $bar; ?></a></li>

    <?php $barId++; } } else { ?>

      <?php
        foreach($barangay as $bar) {
      ?>

      <li><a href="<?php echo site_url('section/guide/'.strtolower(preg_replace('![^a-z0-9]+!i', '-', $bar))); ?>"><i class="fa fa-location-arrow icon"></i> <?php echo $bar; ?></a></li>

      <?php } ?>

    <?php } ?>
    </ul>
  </div>
</div>