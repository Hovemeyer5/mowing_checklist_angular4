import { MowingPage } from './app.po';

describe('mowing App', () => {
  let page: MowingPage;

  beforeEach(() => {
    page = new MowingPage();
  });

  it('should display welcome message', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('Welcome to app!!');
  });
});
