<?php

require_once plugin_dir_path(dirname(__FILE__)) . '/includes/class-qi-gateway-admin-statistics.php';


//Create an instance of our package class...
$qiAdminStatistics = new QI_GATEWAY_ADMIN_STATISTICS();
//Fetch, prepare, sort, and filter our data...
?>
<div class="wrap">
    <div style="width: 100%;text-align: center">
        <img src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/images/qi-logo.png'; ?>" width="200">
    </div>
    <div class="qi-statistics">
        <div class="qi-statistics__card">
            <div class="qi-statistics__icon">
                <svg viewBox="0 0 512 512" xml:space="preserve">
<rect x="76.988" y="15.272" style="fill:#CEE8FA;" width="358.002" height="120.448"/>
                    <g>
                        <path style="fill:#2D527C;" d="M435.005,0H76.995C68.56,0,61.723,6.839,61.723,15.272v452.691c0,13.834,8.258,26.191,21.038,31.484
		c12.78,5.29,27.356,2.393,37.137-7.389c4.296-4.296,10.01-6.663,16.086-6.663c6.077,0,11.79,2.367,16.086,6.663
		C165.365,505.353,182.827,512,200.291,512s34.927-6.647,48.221-19.941c5.964-5.964,5.964-15.634,0-21.6
		c-5.964-5.962-15.634-5.962-21.6,0c-14.678,14.678-38.564,14.678-53.243,0c-20.78-20.778-54.591-20.78-75.371,0.002
		c-1.11,1.106-2.407,1.364-3.85,0.765c-1.448-0.6-2.181-1.697-2.181-3.264V150.991h327.464v316.972c0,1.565-0.733,2.664-2.181,3.264
		c-1.449,0.599-2.741,0.344-3.85-0.767c-20.778-20.777-54.59-20.778-75.371,0l-12.096,12.096c-5.964,5.964-5.964,15.634,0,21.6
		c5.964,5.962,15.634,5.962,21.6,0l12.096-12.096c4.296-4.296,10.01-6.663,16.086-6.663c6.077,0,11.789,2.367,16.086,6.663
		c9.782,9.782,24.361,12.682,37.138,7.387c12.778-5.293,21.036-17.652,21.036-31.483V15.272C450.277,6.839,443.44,0,435.005,0z
		 M92.268,120.446V30.545h327.464v89.901L92.268,120.446L92.268,120.446z"/>
                        <path style="fill:#2D527C;" d="M373.44,272.152h-84.516c-8.435,0-15.272-6.839-15.272-15.272c0-8.433,6.837-15.272,15.272-15.272
		h84.516c8.435,0,15.272,6.839,15.272,15.272C388.712,265.313,381.875,272.152,373.44,272.152z"/>
                        <path style="fill:#2D527C;" d="M373.44,356.151h-84.516c-8.435,0-15.272-6.839-15.272-15.272c0-8.433,6.837-15.272,15.272-15.272
		h84.516c8.435,0,15.272,6.839,15.272,15.272C388.712,349.312,381.875,356.151,373.44,356.151z"/>
                        <path style="fill:#2D527C;" d="M227.402,293.462c-5.636-3.898-15.158-7.76-29.044-11.772v-38.471
		c4.412,1.119,7.739,3.517,10.078,7.227c1.86,3.027,3.006,6.656,3.404,10.785c0.266,2.74,2.569,4.831,5.321,4.831h17.336
		c1.442,0,2.822-0.582,3.829-1.616c1.006-1.032,1.553-2.427,1.515-3.869c-0.327-12.607-4.599-22.994-12.698-30.873
		c-6.976-6.781-16.642-11.021-28.784-12.633v-8.239c0-2.952-2.393-5.345-5.345-5.345h-9.48c-2.952,0-5.345,2.393-5.345,5.345v8.189
		c-12.342,1.139-22.331,5.784-29.748,13.844c-8.287,9.021-12.488,19.416-12.488,30.893c0,12.858,4.056,23.106,12.029,30.433
		c6.773,6.315,16.922,11.042,30.206,14.081v43.803c-6.245-1.474-10.547-4.463-13.07-9.053c-1.338-2.448-3.07-7.499-3.72-17.66
		c-0.18-2.815-2.514-5.003-5.335-5.003h-17.504c-2.952,0-5.345,2.393-5.345,5.345c0,12.571,2.05,22.319,6.251,29.778
		c7.216,12.962,20.23,20.633,38.723,22.84v12.604c0,2.952,2.393,5.345,5.345,5.345h9.48c2.952,0,5.345-2.393,5.345-5.345v-12.791
		c10.523-1.591,18.947-4.392,25.103-8.354c13.165-8.528,19.785-22.733,19.677-42.187
		C243.138,311.508,237.845,300.698,227.402,293.462z M164.537,260.618c0-4.29,1.489-8.388,4.534-12.507
		c1.903-2.54,4.957-4.264,9.118-5.151v33.874c-3.549-1.258-6.531-2.883-8.896-4.849
		C166.048,269.235,164.537,265.625,164.537,260.618z M198.358,311.528c4.993,1.743,7.752,3.248,9.263,4.318
		c4.731,3.352,6.935,7.984,6.935,14.575c0,4.325-0.892,8.039-2.734,11.366c-2.642,4.805-7.073,7.778-13.463,9.008v-39.265H198.358z"
                        />
                    </g>
</svg>
            </div>
            <div class="qi-statistics__info">
                <b><?php echo $qiAdminStatistics->get_total_orders(); ?></b>
                <span> <?php echo __('Total Orders', 'qi-gateway'); ?></span>
            </div>
        </div>
        <div class="qi-statistics__card">
            <div class="qi-statistics__icon">
                <svg viewBox="0 0 512 512" xml:space="preserve">
<rect x="76.988" y="15.272" style="fill:#F4B2B0;" width="358.002" height="120.448"/>
                    <g>
                        <path style="fill:#B3404A;" d="M435.005,0H76.995C68.56,0,61.723,6.839,61.723,15.272v452.691c0,13.834,8.258,26.191,21.038,31.484
		c12.78,5.29,27.356,2.393,37.137-7.389c4.296-4.296,10.01-6.663,16.086-6.663c6.077,0,11.79,2.367,16.086,6.663
		C165.365,505.353,182.827,512,200.291,512s34.927-6.647,48.221-19.941c5.964-5.964,5.964-15.634,0-21.6
		c-5.964-5.962-15.634-5.962-21.6,0c-14.678,14.678-38.564,14.678-53.243,0c-20.78-20.778-54.591-20.78-75.371,0.002
		c-1.11,1.106-2.407,1.364-3.85,0.765c-1.448-0.6-2.181-1.697-2.181-3.264V150.991h327.464v316.972c0,1.565-0.733,2.664-2.181,3.264
		c-1.449,0.599-2.741,0.344-3.85-0.767c-20.778-20.777-54.59-20.778-75.371,0l-12.096,12.096c-5.964,5.964-5.964,15.634,0,21.6
		c5.964,5.962,15.634,5.962,21.6,0l12.096-12.096c4.296-4.296,10.01-6.663,16.086-6.663c6.077,0,11.789,2.367,16.086,6.663
		c9.782,9.782,24.361,12.682,37.138,7.387c12.778-5.293,21.036-17.652,21.036-31.483V15.272C450.277,6.839,443.44,0,435.005,0z
		 M92.268,120.446V30.545h327.464v89.901L92.268,120.446L92.268,120.446z"/>
                        <path style="fill:#B3404A;" d="M373.44,272.152h-84.516c-8.435,0-15.272-6.839-15.272-15.272c0-8.433,6.837-15.272,15.272-15.272
		h84.516c8.435,0,15.272,6.839,15.272,15.272C388.712,265.313,381.875,272.152,373.44,272.152z"/>
                        <path style="fill:#B3404A;" d="M373.44,356.151h-84.516c-8.435,0-15.272-6.839-15.272-15.272c0-8.433,6.837-15.272,15.272-15.272
		h84.516c8.435,0,15.272,6.839,15.272,15.272C388.712,349.312,381.875,356.151,373.44,356.151z"/>
                        <path style="fill:#B3404A;" d="M227.402,293.462c-5.636-3.898-15.158-7.76-29.044-11.772v-38.471
		c4.412,1.119,7.739,3.517,10.078,7.227c1.86,3.027,3.006,6.656,3.404,10.785c0.266,2.74,2.569,4.831,5.321,4.831h17.336
		c1.442,0,2.822-0.582,3.829-1.616c1.006-1.032,1.553-2.427,1.515-3.869c-0.327-12.607-4.599-22.994-12.698-30.873
		c-6.976-6.781-16.642-11.021-28.784-12.633v-8.239c0-2.952-2.393-5.345-5.345-5.345h-9.48c-2.952,0-5.345,2.393-5.345,5.345v8.189
		c-12.342,1.139-22.331,5.784-29.748,13.844c-8.287,9.021-12.488,19.416-12.488,30.893c0,12.858,4.056,23.106,12.029,30.433
		c6.773,6.315,16.922,11.042,30.206,14.081v43.803c-6.245-1.474-10.547-4.463-13.07-9.053c-1.338-2.448-3.07-7.499-3.72-17.66
		c-0.18-2.815-2.514-5.003-5.335-5.003h-17.504c-2.952,0-5.345,2.393-5.345,5.345c0,12.571,2.05,22.319,6.251,29.778
		c7.216,12.962,20.23,20.633,38.723,22.84v12.604c0,2.952,2.393,5.345,5.345,5.345h9.48c2.952,0,5.345-2.393,5.345-5.345v-12.791
		c10.523-1.591,18.947-4.392,25.103-8.354c13.165-8.528,19.785-22.733,19.677-42.187
		C243.138,311.508,237.845,300.698,227.402,293.462z M164.537,260.618c0-4.29,1.489-8.388,4.534-12.507
		c1.903-2.54,4.957-4.264,9.118-5.151v33.874c-3.549-1.258-6.531-2.883-8.896-4.849
		C166.048,269.235,164.537,265.625,164.537,260.618z M198.358,311.528c4.993,1.743,7.752,3.248,9.263,4.318
		c4.731,3.352,6.935,7.984,6.935,14.575c0,4.325-0.892,8.039-2.734,11.366c-2.642,4.805-7.073,7.778-13.463,9.008v-39.265H198.358z"
                        />
                    </g>
</svg>
            </div>
            <div class="qi-statistics__info">
                <b><?php echo $qiAdminStatistics->get_total_unpaid_orders(); ?></b>
                <span> <?php echo __('Total Unpaid Orders', 'qi-gateway'); ?></span>
            </div>
        </div>
        <div class="qi-statistics__card">
            <div class="qi-statistics__icon">
                <svg viewBox="0 0 512 512" xml:space="preserve">
<rect x="76.988" y="15.272" style="fill:#CFF09E;" width="358.002" height="120.448"/>
                    <g>
                        <path style="fill:#507C5C;" d="M435.005,0H76.995C68.56,0,61.723,6.839,61.723,15.272v452.691c0,13.834,8.258,26.191,21.038,31.484
		c12.78,5.29,27.356,2.393,37.137-7.389c4.296-4.296,10.01-6.663,16.086-6.663c6.077,0,11.79,2.367,16.086,6.663
		C165.365,505.353,182.827,512,200.291,512s34.927-6.647,48.221-19.941c5.964-5.964,5.964-15.634,0-21.6
		c-5.964-5.962-15.634-5.962-21.6,0c-14.678,14.678-38.564,14.678-53.243,0c-20.78-20.778-54.591-20.78-75.371,0.002
		c-1.11,1.106-2.407,1.364-3.85,0.765c-1.448-0.6-2.181-1.697-2.181-3.264V150.991h327.464v316.972c0,1.565-0.733,2.664-2.181,3.264
		c-1.449,0.599-2.741,0.344-3.85-0.767c-20.778-20.777-54.59-20.778-75.371,0l-12.096,12.096c-5.964,5.964-5.964,15.634,0,21.6
		c5.964,5.962,15.634,5.962,21.6,0l12.096-12.096c4.296-4.296,10.01-6.663,16.086-6.663c6.077,0,11.789,2.367,16.086,6.663
		c9.782,9.782,24.361,12.682,37.138,7.387c12.778-5.293,21.036-17.652,21.036-31.483V15.272C450.277,6.839,443.44,0,435.005,0z
		 M92.268,120.446V30.545h327.464v89.901L92.268,120.446L92.268,120.446z"/>
                        <path style="fill:#507C5C;" d="M373.44,272.152h-84.516c-8.435,0-15.272-6.839-15.272-15.272c0-8.433,6.837-15.272,15.272-15.272
		h84.516c8.435,0,15.272,6.839,15.272,15.272C388.712,265.313,381.875,272.152,373.44,272.152z"/>
                        <path style="fill:#507C5C;" d="M373.44,356.151h-84.516c-8.435,0-15.272-6.839-15.272-15.272c0-8.433,6.837-15.272,15.272-15.272
		h84.516c8.435,0,15.272,6.839,15.272,15.272C388.712,349.312,381.875,356.151,373.44,356.151z"/>
                        <path style="fill:#507C5C;" d="M227.402,293.462c-5.636-3.898-15.158-7.76-29.044-11.772v-38.471
		c4.412,1.119,7.739,3.517,10.078,7.227c1.86,3.027,3.006,6.656,3.404,10.785c0.266,2.74,2.569,4.831,5.321,4.831h17.336
		c1.442,0,2.822-0.582,3.829-1.616c1.006-1.032,1.553-2.427,1.515-3.869c-0.327-12.607-4.599-22.994-12.698-30.873
		c-6.976-6.781-16.642-11.021-28.784-12.633v-8.239c0-2.952-2.393-5.345-5.345-5.345h-9.48c-2.952,0-5.345,2.393-5.345,5.345v8.189
		c-12.342,1.139-22.331,5.784-29.748,13.844c-8.287,9.021-12.488,19.416-12.488,30.893c0,12.858,4.056,23.106,12.029,30.433
		c6.773,6.315,16.922,11.042,30.206,14.081v43.803c-6.245-1.474-10.547-4.463-13.07-9.053c-1.338-2.448-3.07-7.499-3.72-17.66
		c-0.18-2.815-2.514-5.003-5.335-5.003h-17.504c-2.952,0-5.345,2.393-5.345,5.345c0,12.571,2.05,22.319,6.251,29.778
		c7.216,12.962,20.23,20.633,38.723,22.84v12.604c0,2.952,2.393,5.345,5.345,5.345h9.48c2.952,0,5.345-2.393,5.345-5.345v-12.791
		c10.523-1.591,18.947-4.392,25.103-8.354c13.165-8.528,19.785-22.733,19.677-42.187
		C243.138,311.508,237.845,300.698,227.402,293.462z M164.537,260.618c0-4.29,1.489-8.388,4.534-12.507
		c1.903-2.54,4.957-4.264,9.118-5.151v33.874c-3.549-1.258-6.531-2.883-8.896-4.849
		C166.048,269.235,164.537,265.625,164.537,260.618z M198.358,311.528c4.993,1.743,7.752,3.248,9.263,4.318
		c4.731,3.352,6.935,7.984,6.935,14.575c0,4.325-0.892,8.039-2.734,11.366c-2.642,4.805-7.073,7.778-13.463,9.008v-39.265H198.358z"
                        />
                    </g>
</svg>
            </div>
            <div class="qi-statistics__info">
                <b><?php echo $qiAdminStatistics->get_total_paid_orders(); ?></b>
                <span> <?php echo __('Total Paid Orders Amount', 'qi-gateway'); ?></span>
            </div>
        </div>

    </div>
</div>
