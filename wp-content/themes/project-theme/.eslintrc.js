module.exports = {
    extends: ["eslint:recommended"],
    env: {
        browser: true,
        es6: true,
        node: true,
    },
    parserOptions: {
        ecmaVersion: "latest",
        sourceType: "module",
    },
    rules: {
        "no-console": ["warn", { allow: ["warn", "error"] }],
        "no-unused-vars": ["warn"],
    },
};
