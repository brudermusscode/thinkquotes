<header main fl jucc>
  <a href="/">
    <div id=logo fl jucc alic gap=smol+>
      <div logo-icon>
        <div logo-icon-actual circled style="height:2.4em;width:2.4em;" background=dark-green fl alic jucc>
          <i color=light text midler bold class="si-coffee"></i>
        </div>

        <div class="path-loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4 " stroke-miterlimit="10" />
          </svg>
        </div>
      </div>

      <p text midler bold><?php echo APP_NAME; ?></p>
    </div>
  </a>

  <div inr fl alic jucsb>
    <a href="/">
      <mbutton dno header-arrow-back material="" circled="" icon-only="" background="transparent" size="std" hoverable="">
        <i class="si-arrow-left"></i>
      </mbutton>
    </a>
    <div fl alic gap=smol>
      <mbutton <?php echo PUREMODE_ENABLED ? "active" : ""; ?> js-action="pure-mode:toggle" material has-icon=left size=std background=slighter hoverable>
        <i class="si-square-half"></i>
        Pure
      </mbutton>

      <mbutton dark-mode <?php echo DARKMODE_ENABLED ? "active" : ""; ?> js-action="dark-mode:toggle" material has-icon=left size=std background=slighter hoverable>
        <div dark>
          <i class="si-moon"></i>
          Dark
        </div>
        <div light>
          <i class="si-sun"></i>
          Light
        </div>
      </mbutton>
    </div>
  </div>
</header>