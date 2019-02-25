<ul class="filAriane">
    <?php foreach ($this->arrFilAriane as $item) { ?>
        <li class="filAriane__item">
            <?php if ($item['url']) { ?>
                <a class="filAriane__lien" href="<?php echo $item['url']; ?>"><?php
                    echo $item['libelle']; ?></a>
            <?php } else { ?>
            <?php echo $item['libelle']; ?>
            <?php } ?>
        </li>
    <?php } ?>
</ul>
