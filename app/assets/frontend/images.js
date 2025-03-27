export const load_images = async (arr) => {
  arr.forEach(async (img) => {
    if (img.hasAttribute("loaded")) {
      // console.log("%cAlready loaded: " + img.src, "color:grey;");
      return;
    }

    let new_img = new Image();
    new_img.src = img.src;

    if (new_img.complete) {
      img.setAttribute("loaded", true);
      return;
    }

    img.onerror = () => {
      img.onerror = "";
      // img.src = "/assets/images/default-placeholder.jpg";
      return;
    };

    img.onload = () => {
      img.setAttribute("loaded", true);
      return;
    };
  });
};
