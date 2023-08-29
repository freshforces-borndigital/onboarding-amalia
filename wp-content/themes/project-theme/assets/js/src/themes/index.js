import "./polyfills";
import "../classic/loading";
import "../classic/landingpage";
import "../classic/submission";
import "../classic/dashboard";
import "../classic/login";
import "../classic/popup";
import "../classic/menu";
import * as Pages from "../classic";
import { setStoreValue, subscribe } from "@bd-stores";

subscribe(() => {
	// eslint-disable-next-line no-console
	//console.log("store changes", { store });
}, "isFirebaseInitialized");

setTimeout(() => {
	setStoreValue("isFirebaseInitialized", true);
}, 3000);

Object.keys(Pages).forEach((key) => Pages[key]());

//const testActionWorkflows = () => console.error("blablabla");
//testActionWorkflows();
