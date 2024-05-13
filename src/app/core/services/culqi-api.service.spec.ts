import { TestBed } from '@angular/core/testing';

import { CulqiApiService } from './culqi-api.service';

describe('CulqiApiService', () => {
  let service: CulqiApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CulqiApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
