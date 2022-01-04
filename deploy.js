/* eslint-disable no-console */

// eslint-disable-next-line import/no-extraneous-dependencies
import FtpDeploy from 'ftp-deploy'
import { readFile } from 'fs/promises'
import path from 'path'

async function getSecurityConfig(fname) {
  const packagePath = path.resolve(fname)
  const data = JSON.parse(await readFile(packagePath))
  if (!data.user || !data.password) {
    throw new Error(`invalid security file ${fname}`)
  }
  return data
}

async function buildConfig(target) {
  switch (target) {
    case 'remoteDeploy': {
      if (process.env.NODE_ENV !== 'production') {
        throw new Error('cannot deploy development builds to production, did you mean npx cross-env NODE_ENV=production npm run deploy-remote ?')
      }
      console.error('not yet!')
      process.exit(-1)

      // const security = await getSecurityConfig('.remote.security.json')
      // return {
      //   target,
      //   user: security.user,
      //   password: security.password,
      //   host: 'ftp.some server.com',
      //   port: 21,
      //   localRoot: path.resolve('./dist'),
      //   remoteRoot: '/httpdocs/template/',
      //   include: ['**/*', '.*'],
      //   deleteRemote: false
      // }
    }
    case 'localDeploy': {
      const security = await getSecurityConfig('.local.security.json')
      return {
        target,
        user: security.user,
        password: security.password,
        host: '192.168.1.2',
        port: 21,
        localRoot: path.resolve('./blog2'),
        remoteRoot: './blog2/',
        include: ['**/*', '.*'],
        deleteRemote: false
      }
    }
    default:
      throw new Error(`unknown deployment target '${target}'`)
  }
}

const ftpDeploy = new FtpDeploy()

if (process.argv.length !== 3) {
  console.error('requires target deployment selection')
  process.exit(-1)
}

buildConfig(process.argv[2])
  .then(async config => {
    if (config === undefined) {
      console.error('missing config')
      process.exit(-1)
    }

    const result = await ftpDeploy.deploy(config)
    console.info('finished:', result)
  })
  .catch(err => console.error(err))
