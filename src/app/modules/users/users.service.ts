import User from './users.model'
import { IUser } from './users.interface'
import config from '../../../config'
import { generatedUserId } from './users.utils'

const createUser = async (user: IUser): Promise<IUser | null> => {
  // Auto genareted ID
  const id = await generatedUserId()

  user.id = id

  if (!user.password) {
    user.password = config.default_user_pass as string
  }

  const createdUser = await User.create(user)
  if (!createdUser) {
    throw new Error(`Failed to create user`)
  }
  return createdUser
}

export default {
  createUser,
}
