module.exports = {
  "extends": "stylelint-config-wordpress/scss",
  "plugins": ["stylelint-order", "stylelint-scss"],
  "ignoreFiles": [
    "./inc/**/*",
    "./src/assets/fonts/paymentfont/**/*",
    "./public/**.css",
    "./style.css"
  ],
  "rules": {
      "font-family-no-missing-generic-family-keyword": null,
      "at-rule-no-unknown": null,
      "scss/at-rule-no-unknown": true,
      "no-descending-specificity": null,
      "selector-class-pattern": null,
      "selector-id-pattern": null,
      "declaration-property-unit-whitelist": null,
      "scss/selector-no-redundant-nesting-selector": null,
      "max-line-length": null,
  },
}