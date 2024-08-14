const { watch, src, dest } = require("gulp");
const sass = require("gulp-sass")(require("sass"));

function css() {
  return src("./assets/styles/scss/*.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(dest("./assets/styles/css"));
}

exports.default = function () {
  watch("./assets/styles/scss/*.scss", css);
};
