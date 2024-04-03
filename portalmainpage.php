<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DZNS Portal</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto+Slab|Kaushan+Script');

* {
  box-sizing: border-box;
}

html {
  font-family: "Roboto Slab";
  font-weight: 400;
  font-size: 100%;
  line-height: 1.5;
  color: #f0f0f0;
  height: 100%;
}

body {
  background-color: #111;
  padding: 2rem;
  height: 100%;
}

#root {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
  height: 50%;
}

.item {
  margin: 0.5rem;
  width: 20rem;
  padding: 0.4rem 1rem 0.75rem;
  background-color: #222;

  .title {
    font-family: "Kaushan Script";
    display: block;
    font-size: 2rem;
    margin-left: -0.35rem;
    text-transform: capitalize;
    opacity: 0.5;
  }
  
  .image {
    width: 100%;
    height: 11rem;
    background-size: 100% auto;
    background-position: center center;
    margin: 0.8rem 0 0.7rem 0;
    transition: all 0.25s ease-in-out;
    filter: saturate(0%);
  }
  
  &:hover {
    cursor: pointer;
    
    .image {
      background-size: 105% auto;
      filter: saturate(200%);
    }
  }

  .keywords {
    font-style: italic;
    
    .keyword {
      margin-right: 0.25rem;
      color: white;
      opacity: 0.5;
      text-decoration: none;
      
      &:hover {
        opacity: 1;
        text-decoration: underline;
      }
    }
  }
}
    </style>
</head>
<body>
    <div id="root"></div>
    <script src="assets/js/portalscript.js"></script>
</body>
</html>