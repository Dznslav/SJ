const content = [
    {
      title: 'tabby cat',
      description: 'Look at this adorable tabby cat. Behold her glorious majesty.',
      keywords: [
        'cat',
        'tabby',
        'meow'
      ],
      preview: 'https://images.pexels.com/photos/1034828/pexels-photo-1034828.jpeg'
    },
    {
      title: 'wavy hair',
      description: 'Blonde wavy hair amongst a leafy-green backdrop.',
      keywords: [
        'hair',
        'wavy',
        'blonde',
        'leaves'
      ],
      preview: 'https://images.pexels.com/photos/1049687/pexels-photo-1049687.jpeg'
    },
    {
      title: 'coffee',
      description: 'Woman\'s hands with red nail polish holding a mug of coffee.',
      keywords: [
        'coffee',
        'mug',
        'nail polish',
        'hands',
        'wood'
      ],
      preview: 'https://images.pexels.com/photos/701786/pexels-photo-701786.jpeg'
    },
    {
      title: 'palm trees',
      description: 'Silhouetted palm trees amidst a colorful sunset.',
      keywords: [
        'palm tree',
        'sunset',
        'sky'
      ],
      preview: 'https://images.pexels.com/photos/6741/light-nature-sky-love.jpg'
    }
  ]
  
  function render() {
    let root = document.getElementById('root');
    
    for (i = 0; i < content.length; i++) {
      
      let keywords = '';
      for (x = 0; x < content[i].keywords.length; x++) {
        keywords += `
          <a href="#" class="keyword">
            #${ content[i].keywords[x] }
          </a>
          `;
      }
  
      root.innerHTML += `
        <div class="item">
          <span class="title">
            ${ content[i].title }
          </span>
  
          <span class="description">
            ${ content[i].description }
          </span>
  
          <div class="image"
            style="background-image: url(${ content[i].preview }?auto=compress&cs=tinysrgb&dpr=2&h=190&w=260)">
          </div>
  
          <span class="keywords">
            ${ keywords }
          </span>
        </div>
      `;
    }
  }
  
  render();