"use strict";
var __rest = (this && this.__rest) || function (s, e) {
    var t = {};
    for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p) && e.indexOf(p) < 0)
        t[p] = s[p];
    if (s != null && typeof Object.getOwnPropertySymbols === "function")
        for (var i = 0, p = Object.getOwnPropertySymbols(s); i < p.length; i++) {
            if (e.indexOf(p[i]) < 0 && Object.prototype.propertyIsEnumerable.call(s, p[i]))
                t[p[i]] = s[p[i]];
        }
    return t;
};
class SnippetsFactory {
    static createStartControlsSection(index, label) {
        var _a;
        return `$this->start_controls_section(
            '${index}',
            [
                'label' => __('${label.labelText}', '${(_a = label === null || label === void 0 ? void 0 : label.labelDomain) !== null && _a !== void 0 ? _a : "my-elementor-widget"}'),
                'tab' => \\Elementor\\Controls_Manager::TAB_CONTENT,
            ]
        );`;
    }
    static createEndControlsSection() {
        return `$this->end_controls_section();`;
    }
    static createNormalControl(parentName = "this", control) {
        let defaultValue = `'default' => __('${control.default}', '${(control === null || control === void 0 ? void 0 : control.labelDomain) || "plugin-domain"}')`;
        let labelValue = `'label' => __('${control.labelText}', '${(control === null || control === void 0 ? void 0 : control.labelDomain) || "plugin-domain"}')`;
        if (control.type === "MEDIA") {
            defaultValue = ` 'default' => [
                'url' => \\Elementor\\Utils::get_placeholder_image_src(),
            ]`;
            labelValue = `'label' => esc_html__('${control.labelText}', '${(control === null || control === void 0 ? void 0 : control.labelDomain) || "plugin-domain"}')`;
        }
        let labelBlock = "";
        if (control.type !== "MEDIA")
            labelBlock = "'label_block' => true,";
        let rows = "";
        if (control.type === "CODE")
            rows = `'language' => 'html',
        'rows' => 20,`;
        return `$${parentName}->add_control(
            '${control.accessKey}',
            [
                ${labelValue},
                'type' => \\Elementor\\Controls_Manager::${control.type},
                ${defaultValue},
                ${labelBlock}
                ${rows}
            ]
        );`;
    }
    static createRepeater(parentName = "this", repeater, lines, vars) {
        const repeaterCurrentName = "$" + repeater.repeaterName;
        const parentCurrentName = "$" + parentName;
        lines.push(`${repeaterCurrentName} = new \\Elementor\\Repeater();`);
        for (const child of repeater.children) {
            if (child.type !== "REPEATER") {
                lines.push(SnippetsFactory.createNormalControl(repeater.repeaterName, child));
            }
            else {
                this.createRepeater(repeater.repeaterName, child, lines, vars);
            }
        }
        if (parentName === "this") {
            vars.push(`$${repeater.accessKey} = $settings['${repeater.accessKey}'];`);
        }
        lines.push(`${parentCurrentName}->add_control(
            '${repeater.accessKey}',
            [
                'label' => __('${repeater.labelText}', '${(repeater === null || repeater === void 0 ? void 0 : repeater.labelDomain) || "plugin-domain"}'),
                'type' => \\Elementor\\Controls_Manager::REPEATER,
                'fields' => ${repeaterCurrentName}->get_controls(),
                'default' => [],
                'title_field' => '{{{ ${repeater.titleField} }}}',
            ]
        );`);
    }
}
function compileControlSections(sections) {
    const lines = [];
    const vars = [];
    for (let _a of sections) {
        const { title, children } = _a, label = __rest(_a, ["title", "children"]);
        lines.push(SnippetsFactory.createStartControlsSection(title, label));
        for (const child of children) {
            if (child.type !== "REPEATER") {
                lines.push(SnippetsFactory.createNormalControl("this", child));
                vars.push(`$${child.accessKey} = $settings['${child.accessKey}'];`);
            }
            else {
                SnippetsFactory.createRepeater("this", child, lines, vars);
            }
        }
        lines.push(SnippetsFactory.createEndControlsSection());
    }
    const snippet = lines.join("\n");
    console.log();
    console.log();
    console.log("=============================================");
    console.log("YOUR CONTROL CONFIGURATION TRANSPILED SUCCESSFULLY!");
    console.log("=============================================");
    console.log();
    console.log();
    console.log(`public function _register_controls() {`);
    console.log(snippet);
    console.log();
    console.log(`}`);
    console.log();
    console.log();
    console.log();
    console.log(`protected function render() {`);
    console.log(`$settings = $this->get_settings_for_display();`);
    console.log();
    console.log(vars.join("\n"));
    console.log();
}
const configs = [
    {
        title: "services",
        labelText: "Services",
        children: [
            {
                accessKey: "services_groups",
                repeaterName: "repeater",
                labelText: "Services Groups",
                type: "REPEATER",
                titleField: "service_group_name",
                default: [],
                children: [
                    {
                        type: "TEXT",
                        default: "",
                        accessKey: "service_group_name",
                        labelText: "Service Group Name"
                    },
                    {
                        accessKey: "service_sub_group",
                        repeaterName: "serviceSubGroupRepeater",
                        labelText: "Service Sub Groups",
                        type: "REPEATER",
                        titleField: "service_name",
                        default: [],
                        children: [
                            {
                                type: "TEXT",
                                default: "",
                                accessKey: "service_name",
                                labelText: "Service Name"
                            },
                        ]
                    }
                ]
            }
        ]
    },
    {
        title: "contact",
        labelText: "Contact Information",
        children: [
            {
                type: "WYSIWYG",
                accessKey: "contact_address",
                default: "",
                labelText: "Address"
            },
            {
                type: "TEXT",
                accessKey: "contact_phone_number",
                default: "",
                labelText: "Phone Number"
            }
        ]
    },
    {
        title: "subscribe",
        labelText: "Subscription Information",
        children: [
            {
                type: "WYSIWYG",
                accessKey: "subscrition_description",
                default: "",
                labelText: "Description"
            },
            {
                type: "REPEATER",
                repeaterName: "socialMediaRepeater",
                titleField: "social_media_url",
                accessKey: "social_media_list",
                default: [],
                labelText: "Social Media List",
                children: [
                    {
                        type: "CODE",
                        accessKey: "social_media_icon",
                        default: "",
                        labelText: "Icon"
                    },
                    {
                        type: "TEXT",
                        accessKey: "social_media_url",
                        default: "",
                        labelText: "Url"
                    }
                ]
            }
        ]
    }
];
compileControlSections(configs);
