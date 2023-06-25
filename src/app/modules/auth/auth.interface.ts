export type ILoginUser = {
  id: string;
  password: string;
};

export type ILoginUserResponse = {
  accessToken: string;
  refreshToken?: string;
  needsPasswordChanged: boolean;
};

export type IRefreshTokenResponse = {
  accessToken: string;
};
