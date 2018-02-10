const 
  readline = require('readline'),
  path      = require('path'),
  fs = require('fs');

const rl = readline.createInterface({
  input:process.stdin,
  output:process.stdout
});

rl.question('Search for ?\n',async(q) => {
  try {
    const  
      replaceWith   = await getInput('Replace With ?\n'),
      caseSensitive = await getInput('Case sensitive? (y/n)\n'),
      regex         = new RegExp(q,caseSensitive === 'y' ? 'g' : 'gi');

    rl.write('Search regex : ' + regex + '\n');

    await findAndReplace({
      dirname:path.join(__dirname,'../'),
      ignore:[
        'node_modules',
        '.git',
        '.gitignore',
        'uploads',
  'images',
  'findAndReplace.js'
      ],
      regex,
      replaceWith
    });

    rl.write('Successfully replaced...\n');
  } catch(e) {
    rl.write('Error occured while replacing...\n');
    rl.write(e);
  } finally {
    rl.close();
  }
});

const getInput = (question) => {
  return new Promise((resolve,reject) => {
    rl.question(question,(input) => {
      resolve(input);
    });
  });
}

const findAndReplace = async({ dirname,ignore,regex,replaceWith }) => {
  try {
    let files = fs.readdirSync(dirname);

    if ( files.length === 0 ) return;

    if ( ignore && ignore.length ) {
      files = files.filter(x => !ignore.includes(x));
    }

    for ( const file of files ) {
      const filePath = path.join(dirname,file);

      if ( fs.statSync(filePath).isFile() ) {
        const content = fs.readFileSync(filePath,'utf-8');

        if ( regex.test(content) ) {
          fs.writeFileSync(filePath,content.replace(regex,replaceWith),{
            encoding:'utf-8',
            flag:'w'
          });
        }
      } else {
        await findAndReplace({
          dirname:filePath,
          ignore,
          regex,
          replaceWith
        });
      }
    }
  } catch(e) {
    console.log(e);
    throw e;
  }
}
