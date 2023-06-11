import mongoose from 'mongoose'
import app from './app'
import config from './config'
import { logger, errorLogger } from './shared/logger'

async function bootstrap() {
  try {
    await mongoose.connect(config.database_url as string)
    logger.info(`Database Connect Successfully`)
    app.listen(config.port, () => {
      logger.info(
        `University Management Auth Service app listening on port ${config.port}`
      )
    })
  } catch (error) {
    errorLogger.error(`${error}`)
  }
}

bootstrap()
