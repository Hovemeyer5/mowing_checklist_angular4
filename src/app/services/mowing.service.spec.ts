import { TestBed, inject } from '@angular/core/testing';

import { MowingService } from './mowing.service';

describe('MowingService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [MowingService]
    });
  });

  it('should be created', inject([MowingService], (service: MowingService) => {
    expect(service).toBeTruthy();
  }));
});
