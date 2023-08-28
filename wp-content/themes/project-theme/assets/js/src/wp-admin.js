import "./themes/polyfills";
import * as adminScripts from "./wp-admin/index";

Object.keys(adminScripts).forEach((key) => adminScripts[key]());
