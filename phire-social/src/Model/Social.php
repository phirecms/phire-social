<?php

namespace Phire\Social\Model;

use Phire\Model\AbstractModel;
use Phire\Table;
use Pop\Dom\Child;

class Social extends AbstractModel
{

    /**
     * Constructor
     *
     * Instantiate a model object
     *
     * @param  array $data
     * @return self
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $config = Table\Config::findById('social_config');

        if (isset($config->value) && !empty($config->value) && ($config->value != '')) {
            $cfg        = unserialize($config->value);
            $this->data = array_merge($this->data, $cfg);
        }
    }

    /**
     * Get social config
     *
     * @return array
     */
    public function getConfig()
    {
        $config = Table\Config::findById('social_config');

        if (isset($config->value) && !empty($config->value) && ($config->value != '')) {
            $cfg = unserialize($config->value);
        } else {
            $cfg = [
                'style' => 'shadow',
                'size'  => 'small',
                'order' => [
                    'facebook',
                    'twitter',
                    'instagram',
                    'google',
                    'yelp',
                    'youtube',
                    'vimeo',
                    'vine',
                    'pinterest',
                    'flickr',
                    'linkedin',
                    'blog'
                ],
                'urls'  => [
                    'facebook'  => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'twitter'   => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'instagram' => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'google'    => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'yelp'      => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'youtube'   => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'vimeo'     => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'vine'      => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'pinterest' => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'flickr'    => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'linkedin'  => [
                        'url'   => '',
                        'new'   => true
                    ],
                    'blog'      => [
                        'url'   => '',
                        'new'   => true
                    ]
                ]
            ];
        }

        return $cfg;
    }

    /**
     * Save social config
     *
     * @param  array $post
     * @return void
     */
    public function save(array $post)
    {
        $urls  = [];
        $order = [];
        $blank = [];
        foreach ($post as $key => $value) {
            if (substr($key, 0, 4) == 'url_') {
                $name = substr($key, 4);
                if (!empty($value) && ($value != '')) {
                    $order[((int)$post['order_' . $name] - 1)] = $name;
                    $urls[$name] = [
                        'url' => $value,
                        'new' => (bool)$post['new_' . $name]
                    ];
                } else {
                    $blank[] = $name;
                    $urls[$name] = [
                        'url' => '',
                        'new' => true
                    ];
                }
            }
        }

        ksort($order, SORT_NUMERIC);

        $cfg = [
            'style' => $post['social_style'],
            'size'  => $post['social_size'],
            'order' => array_merge($order, $blank),
            'urls'  => $urls
        ];

        $config = Table\Config::findById('social_config');
        $config->value = serialize($cfg);
        $config->save();
    }

    /**
     * Get styles
     *
     * @return string
     */
    public function getStyles()
    {
        return (isset($this->data['size'])) ? '<link type="text/css" rel="stylesheet" href="' . BASE_PATH . CONTENT_PATH .
            '/assets/phire-social/css/public/phire.social.' . $this->data['size'] . '.css" />' : '';
    }

    /**
     * Build social nav
     *
     * @return mixed
     */
    public function buildNav()
    {
        $nav    = null;
        $hasUrl = false;
        $config = Table\Config::findById('social_config');

        if (isset($config->value) && !empty($config->value) && ($config->value != '')) {
            $cfg        = unserialize($config->value);
            $style      = $cfg['style'];
            $this->data = array_merge($this->data, $cfg);

            switch ($cfg['size']) {
                case 'large':
                    $size = 64;
                    break;
                case 'medium':
                    $size = 48;
                    break;
                default:
                    $size = 32;
            }

            $nav = new Child('nav');
            $nav->setAttribute('class', 'social-media-' . $size);
            foreach ($cfg['order'] as $name) {
                if (!empty($cfg['urls'][$name]['url']) && ($cfg['urls'][$name]['url'] != '')) {
                    $a = new Child('a', ucfirst($name));
                    $a->setAttributes([
                        'class' => $name . '-' . $size . '-' . $style,
                        'href'  => $cfg['urls'][$name]['url']
                    ]);

                    if ($cfg['urls'][$name]['new']) {
                        $a->setAttribute('target', '_blank');
                    }
                    $nav->addChild($a);
                    $hasUrl = true;
                }
            }

            if (!$hasUrl) {
                $nav = null;
            }
        }

        return $nav;
    }

}
