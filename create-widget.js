const fs = require("fs");
const path = require("path");

const args = process.argv.slice(2);

const parsedArgs = args.reduce((acc, curr) => {
    const [key, value] = curr.split('=');
    acc[key.replace(/^-+/, '')] = value;
    return acc;
}, {});


const widgetCode = `<?php
/*
 * Widget Name:       Delinternet {{filename}} Widget
 * Description:       This is a component to render {{filename}}
 * Author:            Jose Aburto
 * Author URI:        https://www.linkedin.com/in/jose-aburto/
 */

namespace Delinternet\Plugins\Widgets;

use Elementor\Widget_Base;


class {{widgetname}} extends Widget_Base
{
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        $this->init_scripts();
    }


    protected function init_scripts()
    {
        wp_enqueue_script('del-{{filename}}-js', plugin_dir_url(__FILE__) . '../assets/js/{{filename}}.js');
        wp_enqueue_style('del-{{filename}}-css', plugin_dir_url(__FILE__) . '../assets/css/{{filename}}.css');
    }

    public function get_name()
    {
        return 'del-{{filename}}';
    }


    public function get_title()
    {
        return __('Delinternet {{widgetname}}', 'delinternet-elementor-widgets');
    }

    public function get_icon()
    {
        return 'eicon-products';
    }

    public function get_categories()
    {
        return ['delinternet'];
    }


    public function _register_controls()
    {}

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="del-{{filename}}">
            Code your widget here.
        </div>
<?php
    }
}
`
// Access the value of 'filename' argument
let filename = parsedArgs.filename.replace(/_/g, '-')


if (!filename.endsWith("_widget")) filename += "-widget"



if (fs.existsSync(path.join(__dirname, "./widgets", `${filename}.php`))) {
    throw new Error(`${filename} file already exists.`);
}




const compiledWidgetCode = widgetCode
    .replace(/{{filename}}/g, filename)
    .replace(/{{widgetname}}/g, filename.replace(/-/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(''))



fs.writeFileSync(path.join(__dirname, "./widgets", `${filename}.php`), compiledWidgetCode);

if (!fs.existsSync(path.join(__dirname, "./assets/js", `${filename}.js`))) {
    fs.writeFileSync(path.join(__dirname, "./assets/js", `${filename}.js`), `console.log("Widget Script connected: ${filename.replace(/-/g, '_')}")`);
}

if (!fs.existsSync(path.join(__dirname, "./assets/css", `${filename}.css`))) {
    fs.writeFileSync(path.join(__dirname, "./assets/css", `${filename}.css`), `.del-${filename} {}`);
}




