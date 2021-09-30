<!-- START PAGE SIDEBAR -->
<div class="page-sidebar">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="index.html">IOR</a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="https://talentlead.gmf-aeroasia.co.id/images/avatar/<?php echo $this->session->userdata('occ_users_1103')->username;?>.jpg" alt="-"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="https://talentlead.gmf-aeroasia.co.id/images/avatar/<?php echo $this->session->userdata('occ_users_1103')->username;?>.jpg"
                </div>
                <div class="profile-data">
                    <div class="profile-data-name"><a><?php echo $this->session->userdata('occ_users_1103')->name;?></a></div>
                    <div class="profile-data-name" class="hidden"><a class="name-name"><?php echo $this->session->userdata('occ_users_1103')->username;?></a></div>
                    <div class="profile-data-title">Unit : <a class="unit-name"><?php echo $this->session->userdata('occ_users_1103')->unit;?></a></div>
                </div>

            </div>                                                                        
        </li>
        <li class="xn-title">Navigation</li>
        <li>
            <a href="<?=site_url('dashboard/home');?>"><span class="fa fa-home"></span> <span class="xn-text">Home</span></a>
        </li>
        <li>
            <a href="<?=site_url('dashboard');?>"><span class="fa fa-file-text"></span> <span class="xn-text">IOR Data</span></a>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Report</span></a>
            <ul>
                <li><a href="<?=site_url('dashboard/Search');?>"><span class="fa fa-list"></span> Search Occurrence</a></li>
                <li><a href="<?=site_url('dashboard/Biweekly');?>"><span class="fa fa-list"></span> Biweekly</a></li>
                <!-- <li><a href="<?=site_url('dashboard/Yearly');?>"><span class="fa fa-list"></span> Yearly</a></li> -->
            </ul>
        </li>
        <?php if ($this->session->userdata('occ_users_1103')->role == 1) { ?>
        
        <!-- <li class="xn-openable">
            <a href="#"><span class="fa fa-gear"></span> <span class="xn-text">Setting</span></a>
            <ul>
                <li><a href="<?=site_url('dashboard/setting');?>"><span class="fa fa-wrench"></span> Category & Subcategory</a></li>
                <li><a href="<?=site_url('#');?>"><span class="fa fa-wrench"></span> Probability Occurrence</a></li>
                <li><a href="<?=site_url('#');?>"><span class="fa fa-wrench"></span> Severity Occurrence</a></li>
                <li><a href="<?=site_url('#');?>"><span class="fa fa-wrench"></span> Admin / Verificator </a></li>
                
            </ul>
        </li> -->                    
        <?php } ?>
    </ul>
    <!-- END X-NAVIGATION -->
</div>
            <!-- END PAGE SIDEBAR -->