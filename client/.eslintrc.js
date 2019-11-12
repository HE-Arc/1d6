module.exports = {
  extends: [
    // add more generic rulesets here, such as:
    // 'eslint:recommended',
    'plugin:vue/recommended'
  ],
  rules: {
    "eqeqeq": "error",
    "semi": "error",
    "curly": "error",
    "brace-style": "error",
    "jsdoc/newline-after-description": "off",
    "space-infix-ops": "error",
    "no-multi-spaces": "error",
    "no-var": "error",
    "no-unused-vars": "warn",
    "keyword-spacing": "error",
    "comma-spacing": "error",
    "indent": [
        2,
        2,
        {
            "SwitchCase": 1,
            "VariableDeclarator": 1
        }
    ]
  }
}