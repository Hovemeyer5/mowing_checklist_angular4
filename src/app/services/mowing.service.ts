import { Injectable } from '@angular/core';

import { MowingPiece } from '../classes/mowingPiece';
import { MOWINGLIST } from '../mock-mowing-list';

@Injectable()
export class MowingService {

  constructor() { }
  getMowingList(today): Promise<MowingPiece[]> {
  	return Promise.resolve(MOWINGLIST);
  }
}
