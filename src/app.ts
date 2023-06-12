import express, { Application, Request, Response } from 'express'
import cors from 'cors'
import globalErrorHandler from './app/middlewares/globalErrorHandler'
import { UserRoutes } from './app/modules/users/user.route'
// import ApiError from './errors/ApiError'

const app: Application = express()

app.use(cors())

app.use(express.json())
app.use(express.urlencoded({ extended: true }))

// Application route
app.use('/api/v1/users/', UserRoutes)

app.get('/', async (req: Request, res: Response) => {
  res.send('Server is Working')
  //   throw new Error('Testing error ')
  //   throw new ApiError(400, 'Orabapre')
  //   // next('Error got on Next')
})

// Global Error handler
app.use(globalErrorHandler)

export default app
