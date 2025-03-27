<?php

use Bruder\Model\Topic;

/**
 * @var User $current_user
 */

/**
 * @var Topic
 */
$RandomTopics = Topic::orderByRaw("RAND()")
  ->limit(4)
  ->get();

/**
 * @var array
 */
$backgrounds = [
  "12279800_4923055.svg" => [
    "v" => 58,
    "h" => 50,
  ],
  "6765045_3435191.svg" => [
    "v" => 70,
    "h" => 50,
  ],
  "7443675_3653670.svg" => [
    "v" => 40,
    "h" => 50,
  ],
  "20177254_6225889.svg" => [
    "v" => 80,
    "h" => 50,
  ],
  "9986512_4282387.svg" => [
    "v" => 50,
    "h" => 50,
  ],
  "9986513_4274014.svg" => [
    "v" => 50,
    "h" => 50,
  ],
  "12344589_4953728.svg" => [
    "v" => 50,
    "h" => 50,
  ],
  "9881645_4267111.svg" => [
    "v" => 50,
    "h" => 50,
  ],
  "12339026_4961758.svg" => [
    "v" => 50,
    "h" => 50,
  ],
];

foreach ($RandomTopics as $Topic) {

  /**
   * @var array
   */
  $random_background = array_rand($backgrounds, 1);
  $background = [
    $random_background => $backgrounds[$random_background]
  ];

  /**
   * @var string
   */
  $background_image = array_key_first($background);

?>

  <box-model topic style="background: transparent url(/assets/images/<?php echo $background_image; ?>) <?php echo $background[$background_image]["h"] . "% " . $background[$background_image]["v"] . "%"; ?> no-repeat;background-size:cover;" rounded>
    <div pv52 fl fldircol alic gap>
      <div fl fldircol jucc gap=smolest text-shadowed=min tac color=light>
        <p text wider bold><?php echo $Topic->name; ?></p>
        <p text midler><?php echo $Topic->quotes_count; ?> quotes</p>
      </div>

      <a href="<?php echo "/topic/$Topic->id"; ?>">
        <mbutton material size=smol has-icon=right outlined=light color=light background=transparent hoverable text-shadowed=min elevated=min>
          Mehr
          <i class="si-arrow-right"></i>
        </mbutton>
      </a>
    </div>
  </box-model>

<?php }

unset($RandomTopics, $Topic);

?>