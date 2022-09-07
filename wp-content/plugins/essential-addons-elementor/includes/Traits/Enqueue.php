<?php
namespace Essential_Addons_Elementor\Pro\Traits;

trait Enqueue
{
    public function enqueue_scripts($has_cache_files)
    {

        if ('' != get_option('eael_save_google_map_api')) {
            wp_enqueue_script(
                'essential_addons_elementor-google-map-api',
                'https://maps.googleapis.com/maps/api/js?key=' . get_option('eael_save_google_map_api') . '',
                array('jquery'),
                EAEL_PRO_PLUGIN_VERSION,
                false
            );
        }

        if (!$has_cache_files) {
            // css
            wp_enqueue_style(
                'eael-pro-lib-view',
                $this->safe_protocol(EAEL_PRO_PLUGIN_URL . 'assets/front-end/css/lib-view/lib-view.min.css'),
                false,
                time()
            );

            wp_enqueue_style(
                'eael-pro-view',
                $this->safe_protocol(EAEL_PRO_PLUGIN_URL . 'assets/front-end/css/view/view.min.css'),
                false,
                time()
            );

            // js
            wp_enqueue_script(
                'eael-pro-lib-view',
                $this->safe_protocol(EAEL_PRO_PLUGIN_URL . 'assets/front-end/js/lib-view/lib-view.min.js'),
                ['jquery'],
                time(),
                true
            );

            wp_enqueue_script(
                'eael-pro-view',
                $this->safe_protocol(EAEL_PRO_PLUGIN_URL . 'assets/front-end/js/view/view.min.js'),
                ['jquery'],
                time(),
                true
            );

            wp_enqueue_script(
                'eael-pro-edit',
                $this->safe_protocol(EAEL_PRO_PLUGIN_URL . 'assets/front-end/js/edit/edit.min.js'),
                ['jquery'],
                time(),
                true
            );
        }
    }

    public function eael_script_localizer($object)
    {
        $object['ajaxurl'] = admin_url('admin-ajax.php');

        $object['ParticleThemesData'] = [
            'default'  => '{"particles":{"number":{"value":160,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}',
            'nasa'     => '{"particles":{"number":{"value":250,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":1,"random":true,"anim":{"enable":true,"speed":1,"opacity_min":0,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":4,"size_min":0.3,"sync":false}},"line_linked":{"enable":false,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":1,"direction":"none","random":true,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":600}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":250,"size":0,"duration":2,"opacity":0,"speed":3},"repulse":{"distance":400,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}',
            'bubble'   => '{"particles":{"number":{"value":15,"density":{"enable":true,"value_area":800}},"color":{"value":"#1b1e34"},"shape":{"type":"polygon","stroke":{"width":0,"color":"#000"},"polygon":{"nb_sides":6},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.3,"random":true,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":50,"random":false,"anim":{"enable":true,"speed":10,"size_min":40,"sync":false}},"line_linked":{"enable":false,"distance":200,"color":"#ffffff","opacity":1,"width":2},"move":{"enable":true,"speed":8,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"grab"},"onclick":{"enable":false,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}',
            'snow'     => '{"particles":{"number":{"value":450,"density":{"enable":true,"value_area":800}},"color":{"value":"#fff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":true,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":5,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":false,"distance":500,"color":"#ffffff","opacity":0.4,"width":2},"move":{"enable":true,"speed":6,"direction":"bottom","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":0.5}},"bubble":{"distance":400,"size":4,"duration":0.3,"opacity":1,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}',
            'nyan_cat' => '{"particles":{"number":{"value":150,"density":{"enable":false,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"star","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"http://wiki.lexisnexis.com/academic/images/f/fb/Itunes_podcast_icon_300.jpg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":4,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":false,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":14,"direction":"left","random":false,"straight":true,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"grab"},"onclick":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":200,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}',
        ];

        return $object;
    }

    public function eael_admin_scripts($hook)
    {
        if ($hook == 'toplevel_page_eael-settings') {
            wp_enqueue_script(
                'eael-pro-admin-script',
                EAEL_PRO_PLUGIN_URL . '/assets/admin/js/admin.js',
                ['jquery']
            );

            wp_localize_script(
                'eael-pro-admin-script',
                'eaelAdmin', [
                    'eael_admin_ajax_url' => admin_url('admin-ajax.php'),
                    'eael_mailchimp_api'  => get_option('eael_save_mailchimp_api'),
                    'eael_google_map_api' => get_option('eael_save_google_map_api'),
                    'nonce'               => wp_create_nonce('essential-addons-elementor'),
                ]
            );
        }

    }
}
